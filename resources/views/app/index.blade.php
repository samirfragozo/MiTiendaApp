@extends((!empty($form ?? []) and !empty($table ?? [])) ? 'layouts.crud' : (!empty($table ?? []) ? 'layouts.table' : 'layouts.form'))

@section('title', $title)

@section('subtitle', $subtitle ?? null)

@section('subtitle_form', $subtitle_form ?? null)

@section('tools')
    @component('components.tools', [
        'crud' => $crud,
        'create' => $tools['create'] ?? false and !empty($form),
        'reload' => $tools['reload'] ?? false,
        'changeStatus' => $table['active'] ?? false,
    ])@endcomponent
@endsection

@section('filters')
    @component('components.filters', [
        'crud' => $crud,
        'active' => $table['active'] ?? false,
        'fields' => $filters ?? [],
    ])@endcomponent
@endsection

@section('table')
    @component('components.table', [
        'check' => $table['check'] ?? false,
        'fields' => $table['fields'] ?? [],
        'active' => $table['active'] ?? false,
        'actions' => $table['actions'] ?? false,
    ])@endcomponent
@endsection

@section('form')
    @component('components.wizard', [
        'crud' => $crud,
        'fields' => $form ?? [],
    ])@endcomponent
@endsection

@push('scripts')
    @include('includes.scripts')
    @if (file_exists('js/cruds/' . $crud . '.js')) {
        <script type="text/javascript" language="javascript" src="{{ asset('js/cruds/' . $crud . '.js') }}" defer></script>
    @endif
    @if($crud === 'stores' or $crud === 'storekeeper.stores')
        <script type="text/javascript" language="javascript" src="{{ asset('js/cruds/map.js') }}" defer></script>
        <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBlwXdHpCibPpppRQS4xhLOB7KxQvq-hL8" type="text/javascript"></script>
    @endif
@endpush