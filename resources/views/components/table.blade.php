<div class="m-loader m-loader--brand table-loader" style="display: inline-block; width: 100%;"></div>
<table class="table table-striped- table-bordered table-hover table-checkable m--hide table-component ajax" id="table">
    <thead>
    <tr>
        @if(isset($check) and $check)
            <th name="check" class=" dt-center">
                <label class="m-checkbox m-checkbox--single m-checkbox--solid m-checkbox--brand">
                    {{ Form::checkbox('massive', null, false, ['class' => 'm-group-checkable']) }}
                    <span></span>
                </label>
            </th>
        @endif
        @foreach($fields as $field)
            <th name="{{ $field }}">{{__('validation.attributes.' . $field)}}</th>
        @endforeach
        @if(isset($active) and $active)
            <th name="active" class='dt-center'>{{__('validation.attributes.active')}}</th>
        @endif
        @if(isset($actions) and $actions)
            <th name="actions" class='dt-center'>{{__('validation.attributes.actions')}}</th>
        @endif
    </tr>
    </thead>
</table>
