<p>{{ trans('strings.emails.contact.email_body_title') }}</p>

<p><strong>{{ trans('validation.attributes.frontend.name') }}:</strong> {{ $request->name }}</p>
<p><strong>{{ trans('validation.attributes.frontend.email') }}:</strong> {{ $request->email }}</p>
<p><strong>{{ trans('validation.attributes.frontend.phone') }}:</strong> {{ $request->phone ?? "N/A" }}</p>
<p><strong>{{ trans('validation.attributes.frontend.address') }}:</strong> {{ $request->address }}</p>
<p><strong>{{ trans('validation.attributes.frontend.comment') }}:</strong> {{ $request->comment }}</p>