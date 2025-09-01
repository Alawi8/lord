@component('lord::emails.layout')
    <div style="margin-bottom: 34px;">
        <p style="font-size: 16px;color: #384860;line-height: 24px;">
            {{ $contactUs['message'] }}
        </p>
    </div>

        <p style="font-size: 16px;color: #384860;line-height: 24px;margin-bottom: 40px">
            @lang('lord::app.emails.contact-us.to')
            
            <a href="mailto:{{ $contactUs['email'] }}">{{ $contactUs['email'] }}</a>,

            @lang('lord::app.emails.contact-us.reply-to-mail')

            @if($contactUs['contact'])
                @lang('lord::app.emails.contact-us.reach-via-phone')

                <a href="tel:{{ $contactUs['contact'] }}">{{ $contactUs['contact'] }}</a>.
            @endif
        </p>
    </p>
@endcomponent