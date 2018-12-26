<div class="m-portlet__body m--padding-10">
    {{Form::open(['id' => 'form', 'files' => true])}}
    {{Form::hidden('id', '0', ['id' => 'id_form'])}}
    @component('components.fields', [
        'crud' => $crud,
        'fields' => $fields,
        'suffix' => 'form'
    ])
    @endcomponent
    {{Form::close()}}
</div>
<div class="m-portlet__foot">
    <div class="row align-items-center">
        <div class="col-lg-12">
            {{Form::button(__('base.buttons.create'), ['id' => 'formButton', 'class' => 'btn btn-primary', 'data-action' => 'create'])}}
            {{Form::button(__('base.buttons.cancel'), ['id' => 'formReset', 'class' => 'btn btn-secondary'])}}
        </div>
    </div>
</div>
