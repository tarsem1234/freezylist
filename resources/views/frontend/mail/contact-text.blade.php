{{ trans('strings.emails.contact.email_body_title') }}

{{ trans('validation.attributes.frontend.name') }}: {{ $request->name }}
{{ trans('validation.attributes.frontend.email') }}: {{ $request->email }}
{{ trans('validation.attributes.frontend.phone') }}: {{ $request->phone ?? "N/A" }}
{{ trans('validation.attributes.frontend.address') }}: {{ $request->address }}
{{ trans('validation.attributes.frontend.comment') }}: {{ $request->comment }}