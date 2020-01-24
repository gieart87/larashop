@extends('admin.layout')

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-5">
                    @include('admin.attributes.option_form')
            </div>
            <div class="col-lg-7">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom">
                        <h2>Options for : {{ $attribute->name }}</h2>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-stripped">
                            <thead>
                                <th style="width:10%">#</th>
                                <th>Name</th>
                                <th style="width:30%">Action</th>
                            </thead>
                            <tbody>
                                @forelse ($attribute->attributeOptions as $option)
                                    <tr>    
                                        <td>{{ $option->id }}</td>
                                        <td>{{ $option->name }}</td>
                                        <td>
                                            @can('edit_attributes')
                                                <a href="{{ url('admin/attributes/options/'. $option->id .'/edit') }}" class="btn btn-warning btn-sm">edit</a>
                                            @endcan

                                            @can('delete_attributes')
                                                {!! Form::open(['url' => 'admin/attributes/options/'. $option->id, 'class' => 'delete', 'style' => 'display:inline-block']) !!}
                                                {!! Form::hidden('_method', 'DELETE') !!}
                                                {!! Form::submit('remove', ['class' => 'btn btn-danger btn-sm']) !!}
                                                {!! Form::close() !!}
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5">No records found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection