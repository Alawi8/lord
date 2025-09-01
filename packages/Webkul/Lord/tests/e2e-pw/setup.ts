import { test as base, expect, type Page } from "@playwright/test";

interface LordPage extends Page {
    fillInTinymce: (iframeSelector: string, content: string) => Promise<void>;
}

type LordFixtures = {
    lordPage: LordPage;
};

export const test = base.extend<LordFixtures>({
    lordPage: async ({ browser }, use) => {
        const context = await browser.newContext();

        const page = await context.newPage();

        /**
         * Extend the page object with custom methods.
         */
        (page as LordPage).fillInTinymce = async function (
            iframeSelector: string,
            content: string
        ) {
            await page.waitForSelector(iframeSelector);
            const iframe = page.frameLocator(iframeSelector);
            const editorBody = iframe.locator("body");
            await editorBody.click();
            await editorBody.pressSequentially(content);
            await expect(editorBody).toHaveText(content);
        };

        await use(page as LordPage);
        await context.close();
    },
});

export { expect };
