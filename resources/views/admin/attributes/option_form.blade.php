<div class="card card-default">
    <div class="card-header card-header-border-bottom">
            <h2>Add Option</h2>
    </div>
    <div class="card-body">
        @include('admin.partials.flash', ['$errors' => $errors])
        @if (!empty($attributeOption))
            {!! Form::model($attributeOption, ['url' => ['admin/attributes/options', $attributeOption->id], 'method' => 'PUT']) !!}
            {!! Form::hidden('id') !!}
        @else
            {!! Form::open(['url' => ['admin/attributes/options', $attribute->id], 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
        @endif
        {!! Form::hidden('attribute_id', $attribute->id) !!}
        <div class="form-group">
            {!! Form::label('name', 'Name') !!}
            {!! Form::text('name', null, ['class' => 'form-control']) !!}
        </div>
        <div class="form-footer pt-5 border-top">
            <button type="submit" class="btn btn-primary btn-default">Save</button>
            <a href="{{ url('admin/attributes/') }}" class="btn btn-secondary btn-default">Back</a>
        </div>
        {!! Form::close() !!}
    </div>
</div> 