<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;

class ProjectFilesJson extends Command
{
    protected $signature = 'project:files-json {--path=storage/files_dump.json} {--max-file-size=512} {--exclude-large-dirs} {--limit=500}';
    protected $description = 'Generate a JSON dump of specific project files with strict 31MB limit';

    // Memory and performance settings - محدث للحد من 31MB
    private const MAX_FILE_SIZE_KB = 512; // 512KB default (مخفض من 1MB)
    private const MEMORY_LIMIT = '512M'; // زيادة الذاكرة المتاحة للمعالجة
    private const CHUNK_SIZE = 50; // تقليل حجم المجموعات
    private const MAX_OUTPUT_SIZE_MB = 31; // الحد الأقصى لحجم الملف النهائي
    private const MAX_CONTENT_LENGTH = 50000; // تقليل الحد الأقصى لطول المحتوى (من 100KB إلى 50KB)

    // Directories to exclude - محسن
    private const EXCLUDED_DIRS = [
        'node_modules',
        'vendor',
        'storage/logs',
        'storage/framework/cache',
        'storage/framework/sessions',
        'storage/framework/views',
        'bootstrap/cache',
        '.git',
        'public/storage',
        'storage/app/public',
        'storage/debugbar', // إضافة
        'storage/clockwork', // إضافة
        '.vscode',
        '.idea',
        'tests/Browser/screenshots'
    ];

    private int $currentOutputSize = 0; // تتبع حجم البيانات المجمعة
    private int $maxOutputBytes;

    public function __construct()
    {
        parent::__construct();
        $this->maxOutputBytes = self::MAX_OUTPUT_SIZE_MB * 1024 * 1024; // تحويل إلى بايت
    }

    public function handle()
    {
        // Set memory limit
        ini_set('memory_limit', self::MEMORY_LIMIT);
        
        $jsonPath = base_path($this->option('path'));
        $maxFileSizeKb = min((int) $this->option('max-file-size'), self::MAX_FILE_SIZE_KB);
        $excludeLargeDirs = true; // دائماً مفعل
        $fileLimit = min((int) $this->option('limit'), 500); // حد أقصى 500 ملف لكل فئة

        try {
            $this->info("🔄 بدء جمع ملفات المشروع (محدود بـ 31MB)...");
            $this->info("📏 الحد الأقصى لحجم الملف: {$maxFileSizeKb}KB");
            $this->info("📊 حد الملفات: {$fileLimit} ملف لكل فئة");
            $this->info("🎯 الحد الأقصى لحجم الإخراج: " . self::MAX_OUTPUT_SIZE_MB . "MB");

            $projectData = $this->buildProjectStructure($maxFileSizeKb, $excludeLargeDirs, $fileLimit);

            // التحقق من جمع البيانات
            if (empty($projectData) || empty($projectData['filesByCategory'])) {
                $this->error("❌ لم يتم جمع أي بيانات. تحقق من وجود المسارات.");
                return 1;
            }

            // إنشاء المجلد إذا لم يكن موجوداً
            $directory = dirname($jsonPath);
            if (!File::exists($directory)) {
                File::makeDirectory($directory, 0755, true);
            }

            // حفظ JSON مع التحقق من الحجم
            $this->saveJsonWithSizeControl($projectData, $jsonPath);

            $finalSize = filesize($jsonPath);
            $this->info("📦 تم إنشاء ملف المشروع بنجاح!");
            $this->info("📍 المكان: $jsonPath");
            $this->info("📊 إجمالي الملفات: " . $projectData['summary']['totalFiles']);
            $this->info("📈 حجم البيانات: " . $this->formatBytes($projectData['summary']['totalSize']));
            $this->info("📄 حجم ملف JSON: " . $this->formatBytes($finalSize));
            
            if ($finalSize > $this->maxOutputBytes) {
                $this->warn("⚠️  تحذير: حجم الملف يتجاوز 31MB");
            } else {
                $this->info("✅ الحجم ضمن الحد المسموح (31MB)");
            }

            return 0;
        } catch (\Exception $e) {
            $this->error("❌ حدث خطأ: " . $e->getMessage());
            $this->error("🔍 تفاصيل الخطأ: " . $e->getTraceAsString());
            return 1;
        }
    }

    private function buildProjectStructure(int $maxFileSizeKb, bool $excludeLargeDirs, int $fileLimit): array
    {
        $startTime = microtime(true);
        $totalFiles = 0;
        $totalSize = 0;
        $skippedFiles = 0;

        // تحسين مصادر الملفات - أولوية للملفات المهمة
        $sources = [
            'config' => [
                'displayName' => 'ملفات الإعدادات',
                'description' => 'ملفات إعدادات التطبيق',
                'path' => base_path('config'),
                'extensions' => ['php'],
                'maxDepth' => 2,
                'priority' => 1
            ],
            'routes' => [
                'displayName' => 'ملفات المسارات',
                'description' => 'تعريفات مسارات التطبيق',
                'path' => base_path('routes'),
                'extensions' => ['php'],
                'maxDepth' => 2,
                'priority' => 1
            ],
            'app' => [
                'displayName' => 'التطبيق الأساسي',
                'description' => 'ملفات التطبيق الرئيسية',
                'path' => base_path('app'),
                'extensions' => ['php'],
                'maxDepth' => 4,
                'priority' => 2,
                'priorityPatterns' => ['Http/Controllers', 'Models', 'Services']
            ],
            'bagisto_packages' => [
                'displayName' => 'حزم Bagisto',
                'description' => 'ملفات حزم Bagisto المهمة',
                'path' => base_path('packages/Webkul/Shop'),
                'extensions' => ['php', 'blade.php'],
                'maxDepth' => 3,
                'priority' => 2,
                'priorityPatterns' => ['src/Config', 'src/Http/Controllers', 'src/Models', 'src/Resources/views']
            ],
            'database' => [
                'displayName' => 'ملفات قاعدة البيانات',
                'description' => 'الهجرات والبذور والمصانع',
                'path' => base_path('database'),
                'extensions' => ['php'],
                'maxDepth' => 3,
                'priority' => 3
            ],
            'env' => [
                'displayName' => 'ملفات البيئة',
                'description' => 'ملفات إعدادات البيئة',
                'path' => base_path(),
                'extensions' => [],
                'specificFiles' => ['.env.example'],
                'priority' => 1
            ],
            'composer' => [
                'displayName' => 'إعدادات Composer',
                'description' => 'ملفات إدارة التبعيات',
                'path' => base_path(),
                'extensions' => [],
                'specificFiles' => ['composer.json', 'composer.lock'],
                'priority' => 1
            ]
        ];

        // ترتيب المصادر حسب الأولوية
        uasort($sources, function($a, $b) {
            return ($a['priority'] ?? 99) <=> ($b['priority'] ?? 99);
        });

        $filesByCategory = [];

        foreach ($sources as $categoryKey => $categoryInfo) {
            // التحقق من عدم تجاوز الحد الأقصى للحجم
            if ($this->currentOutputSize >= $this->maxOutputBytes * 0.8) { // توقف عند 80% من الحد
                $this->warn("⚠️  تم الوصول لـ 80% من الحد الأقصى، توقف المعالجة");
                break;
            }

            $this->info("🔍 فحص: " . $categoryInfo['displayName']);

            if (!File::exists($categoryInfo['path'])) {
                $this->warn("⚠️  المسار غير موجود: " . $categoryInfo['path']);
                continue;
            }

            $categoryFiles = [];
            $categorySize = 0;
            $categoryFileCount = 0;

            try {
                // معالجة الملفات المحددة
                if (isset($categoryInfo['specificFiles'])) {
                    foreach ($categoryInfo['specificFiles'] as $specificFile) {
                        if ($this->currentOutputSize >= $this->maxOutputBytes * 0.8) break;
                        
                        $filePath = $categoryInfo['path'] . DIRECTORY_SEPARATOR . $specificFile;
                        if (File::exists($filePath)) {
                            $fileData = $this->processFileOptimized($filePath, $maxFileSizeKb);
                            if ($fileData && $this->canAddFile($fileData)) {
                                $categoryFiles[] = $fileData;
                                $categorySize += $fileData['fileInfo']['size'];
                                $categoryFileCount++;
                                $this->updateOutputSize($fileData);
                            }
                        }
                    }
                } else {
                    // فحص المجلدات مع التحسينات
                    $files = $this->getOptimizedFileList(
                        $categoryInfo['path'],
                        $categoryInfo['extensions'],
                        $excludeLargeDirs,
                        $categoryInfo['maxDepth'] ?? 10,
                        $categoryInfo['priorityPatterns'] ?? []
                    );

                    // تحديد عدد الملفات المسموح حسب الأولوية
                    $allowedFiles = match($categoryInfo['priority'] ?? 3) {
                        1 => $fileLimit, // أولوية عالية - العدد الكامل
                        2 => (int)($fileLimit * 0.7), // أولوية متوسطة - 70%
                        default => (int)($fileLimit * 0.5) // أولوية منخفضة - 50%
                    };

                    $files = array_slice($files, 0, $allowedFiles);

                    $this->info("📁 معالجة " . count($files) . " ملف في " . $categoryInfo['displayName']);

                    // معالجة الملفات في مجموعات
                    $chunks = array_chunk($files, self::CHUNK_SIZE);

                    foreach ($chunks as $chunk) {
                        if ($this->currentOutputSize >= $this->maxOutputBytes * 0.8) break;

                        foreach ($chunk as $filePath) {
                            if ($categoryFileCount >= $allowedFiles || 
                                $this->currentOutputSize >= $this->maxOutputBytes * 0.8) {
                                break 2;
                            }

                            $fileData = $this->processFileOptimized($filePath, $maxFileSizeKb);
                            if ($fileData && $this->canAddFile($fileData)) {
                                $categoryFiles[] = $fileData;
                                $categorySize += $fileData['fileInfo']['size'];
                                $categoryFileCount++;
                                $this->updateOutputSize($fileData);
                            } else {
                                $skippedFiles++;
                            }
                        }

                        // تنظيف الذاكرة
                        if (memory_get_usage() > 400 * 1024 * 1024) { // 400MB
                            gc_collect_cycles();
                        }
                    }
                }

                $totalFiles += $categoryFileCount;
                $totalSize += $categorySize;

            } catch (\Exception $e) {
                $this->error("❌ خطأ في فحص " . $categoryInfo['path'] . ": " . $e->getMessage());
            }

            $filesByCategory[$categoryKey] = [
                'categoryInfo' => $categoryInfo,
                'files' => $categoryFiles,
                'statistics' => [
                    'fileCount' => $categoryFileCount,
                    'totalSize' => $categorySize,
                    'totalSizeFormatted' => $this->formatBytes($categorySize)
                ]
            ];

            // تفريغ متغيرات الفئة من الذاكرة
            unset($categoryFiles);
            
            $this->info("📊 تمت معالجة {$categoryFileCount} ملف - الحجم الحالي: " . $this->formatBytes($this->currentOutputSize));
        }

        $endTime = microtime(true);
        $executionTime = round(($endTime - $startTime) * 1000, 2);

        if ($skippedFiles > 0) {
            $this->warn("⚠️  تم تخطي {$skippedFiles} ملف (كبير جداً أو غير قابل للقراءة)");
        }

        return [
            'projectInfo' => [
                'projectName' => config('app.name', 'مشروع Laravel'),
                'laravelVersion' => app()->version(),
                'phpVersion' => PHP_VERSION,
                'generatedAt' => Carbon::now()->toISOString(),
                'generatedBy' => 'Laravel Artisan Command: project:files-json (محسن - 31MB)',
                'executionTimeMs' => $executionTime,
                'optimizations' => [
                    'maxFileSizeKb' => $maxFileSizeKb,
                    'maxOutputSizeMb' => self::MAX_OUTPUT_SIZE_MB,
                    'excludedLargeDirs' => $excludeLargeDirs,
                    'fileLimit' => $fileLimit,
                    'skippedFiles' => $skippedFiles,
                    'maxContentLength' => self::MAX_CONTENT_LENGTH
                ]
            ],
            'summary' => [
                'totalFiles' => $totalFiles,
                'totalSize' => $totalSize,
                'totalSizeFormatted' => $this->formatBytes($totalSize),
                'categoriesCount' => count($filesByCategory),
                'estimatedJsonSize' => $this->formatBytes($this->currentOutputSize),
                'memoryUsage' => $this->formatBytes(memory_get_peak_usage(true))
            ],
            'filesByCategory' => $filesByCategory
        ];
    }

    private function canAddFile(array $fileData): bool
    {
        // تقدير حجم الملف في JSON (تقريبي)
        $estimatedJsonSize = strlen(json_encode($fileData, JSON_UNESCAPED_SLASHES));
        return ($this->currentOutputSize + $estimatedJsonSize) < ($this->maxOutputBytes * 0.8);
    }

    private function updateOutputSize(array $fileData): void
    {
        // تحديث الحجم المقدر للإخراج
        $estimatedJsonSize = strlen(json_encode($fileData, JSON_UNESCAPED_SLASHES));
        $this->currentOutputSize += $estimatedJsonSize;
    }

    private function getOptimizedFileList(string $path, array $extensions, bool $excludeLargeDirs, int $maxDepth, array $priorityPatterns): array
    {
        $files = [];
        $priorityFiles = [];

        try {
            $iterator = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($path, \RecursiveDirectoryIterator::SKIP_DOTS),
                \RecursiveIteratorIterator::SELF_FIRST
            );

            $iterator->setMaxDepth($maxDepth);

            foreach ($iterator as $file) {
                if (!$file->isFile()) continue;

                $filePath = $file->getPathname();
                $relativePath = str_replace($path . DIRECTORY_SEPARATOR, '', $filePath);

                // تخطي المجلدات المستبعدة
                if ($this->shouldExcludeFile($relativePath)) {
                    continue;
                }

                // فحص امتداد الملف
                if (!$this->isValidFileExtension($file, $extensions)) {
                    continue;
                }

                // فحص حجم الملف قبل الإضافة (حد أقصى 5MB لكل ملف)
                if ($file->getSize() > 5 * 1024 * 1024) {
                    continue;
                }

                // إعطاء أولوية للملفات المهمة
                if ($this->isPriorityFile($relativePath, $priorityPatterns)) {
                    $priorityFiles[] = $filePath;
                } else {
                    $files[] = $filePath;
                }
            }
        } catch (\Exception $e) {
            $this->warn("⚠️  خطأ في قراءة المجلد $path: " . $e->getMessage());
        }

        // إرجاع الملفات ذات الأولوية أولاً
        return array_merge($priorityFiles, $files);
    }

    private function shouldExcludeFile(string $relativePath): bool
    {
        foreach (self::EXCLUDED_DIRS as $excludedDir) {
            if (str_starts_with($relativePath, $excludedDir)) {
                return true;
            }
        }
        
        // استبعاد ملفات إضافية
        $excludedPatterns = [
            'storage/framework/',
            'bootstrap/cache/',
            '.phpunit.result.cache',
            'npm-debug.log',
            'yarn-error.log'
        ];
        
        foreach ($excludedPatterns as $pattern) {
            if (str_contains($relativePath, $pattern)) {
                return true;
            }
        }
        
        return false;
    }

    private function isPriorityFile(string $relativePath, array $priorityPatterns): bool
    {
        foreach ($priorityPatterns as $pattern) {
            if (str_contains($relativePath, $pattern)) {
                return true;
            }
        }
        return false;
    }

    private function processFileOptimized(string $filePath, int $maxFileSizeKb): ?array
    {
        try {
            if (!File::exists($filePath)) {
                return null;
            }

            $fileInfo = new \SplFileInfo($filePath);
            $fileSize = $fileInfo->getSize();

            // تخطي الملفات الكبيرة جداً
            if ($fileSize > $maxFileSizeKb * 1024) {
                return null;
            }

            $content = file_get_contents($filePath);
            if ($content === false) {
                return null;
            }

            // قطع المحتوى إذا كان كبيراً جداً
            $originalLength = strlen($content);
            if ($originalLength > self::MAX_CONTENT_LENGTH) {
                $content = substr($content, 0, self::MAX_CONTENT_LENGTH) . 
                          "\n\n... [تم قطع المحتوى - الطول الأصلي: " . $this->formatBytes($originalLength) . "]";
            }

            // تنظيف وتحويل المحتوى إلى UTF-8
            $cleanContent = $this->cleanContent($content);

            return [
                'fileInfo' => [
                    'fileName' => $fileInfo->getFilename(),
                    'relativePath' => str_replace(base_path() . DIRECTORY_SEPARATOR, '', $filePath),
                    'extension' => $fileInfo->getExtension(),
                    'size' => $fileSize,
                    'sizeFormatted' => $this->formatBytes($fileSize),
                    'contentLength' => strlen($cleanContent),
                    'truncated' => $originalLength > self::MAX_CONTENT_LENGTH
                ],
                'fileContent' => [
                    'content' => $cleanContent,
                ]
            ];
        } catch (\Exception $e) {
            return null;
        }
    }

    private function cleanContent(string $content): string
    {
        // تنظيف المحتوى وإزالة الأحرف غير المرغوبة
        $content = mb_convert_encoding($content, 'UTF-8', 'UTF-8');
        
        // إزالة الأحرف التي قد تسبب مشاكل في JSON
        $content = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', '', $content);
        
        return $content;
    }

    private function saveJsonWithSizeControl(array $data, string $path): void
    {
        // محاولة حفظ البيانات مع التحكم في الحجم
        $tempPath = $path . '.tmp';
        
        $handle = fopen($tempPath, 'w');
        if (!$handle) {
            throw new \Exception("لا يمكن فتح الملف للكتابة: $tempPath");
        }

        try {
            $options = JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PARTIAL_OUTPUT_ON_ERROR;
            
            // حفظ البيانات الأساسية أولاً
            $basicData = [
                'projectInfo' => $data['projectInfo'],
                'summary' => $data['summary']
            ];
            
            $jsonContent = json_encode($basicData, $options);
            if ($jsonContent === false) {
                throw new \Exception("فشل في تشفير JSON الأساسي: " . json_last_error_msg());
            }
            
            // إضافة الملفات تدريجياً مع فحص الحجم
            $currentSize = strlen($jsonContent);
            $processedCategories = [];
            
            foreach ($data['filesByCategory'] as $categoryKey => $categoryData) {
                $categoryJson = json_encode($categoryData, $options);
                $categorySize = strlen($categoryJson);
                
                if ($currentSize + $categorySize < $this->maxOutputBytes) {
                    $processedCategories[$categoryKey] = $categoryData;
                    $currentSize += $categorySize;
                } else {
                    $this->warn("⚠️  تم تخطي فئة '{$categoryData['categoryInfo']['displayName']}' لتجنب تجاوز 31MB");
                    break;
                }
            }
            
            // حفظ البيانات النهائية
            $finalData = array_merge($basicData, ['filesByCategory' => $processedCategories]);
            $finalJson = json_encode($finalData, $options);
            
            if ($finalJson === false) {
                throw new \Exception("فشل في تشفير JSON النهائي: " . json_last_error_msg());
            }
            
            fwrite($handle, $finalJson);
            fclose($handle);
            
            // نقل الملف المؤقت إلى المكان النهائي
            if (file_exists($path)) {
                unlink($path);
            }
            rename($tempPath, $path);
            
        } catch (\Exception $e) {
            fclose($handle);
            if (file_exists($tempPath)) {
                unlink($tempPath);
            }
            throw $e;
        }
    }

    private function isValidFileExtension(\SplFileInfo $file, array $allowedExtensions): bool
    {
        if (empty($allowedExtensions)) {
            return true;
        }

        $extension = strtolower($file->getExtension());
        $fileName = $file->getFilename();

        // معالجة ملفات blade.php
        if (str_ends_with(strtolower($fileName), '.blade.php') && in_array('blade.php', $allowedExtensions)) {
            return true;
        }

        return in_array($extension, array_map('strtolower', $allowedExtensions));
    }

    private function formatBytes(int $bytes): string
    {
        if ($bytes === 0) return '0 B';
        
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);

        return round($bytes, 2) . ' ' . $units[$pow];
    }
}