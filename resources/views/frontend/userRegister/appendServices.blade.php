<select class="service-select form-control" name="services[]" id="services-selection" multiple="multiple">
    @if(!empty($services))
    @foreach($services as $key=>$service)
        <option value="{{ $service->id }}">{{ $service->service }}</option>
    @endforeach
    @endif
</select>