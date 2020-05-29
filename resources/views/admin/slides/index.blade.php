@extends('admin.layout')

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom">
                        <h2>Slides</h2>
                    </div>
                    <div class="card-body">
                        @include('admin.partials.flash')
                        <table class="table table-bordered table-stripped">
                            <thead>
                                <th>#</th>
                                <th>Title</th>
                                <th>Image</th>
                                <th>Position</th>
                                <th>Status</th>
                                <th>Action</th>
                            </thead>
                            <tbody>
                                @forelse ($slides as $slide)
                                    <tr>    
                                        <td>{{ $slide->id }}</td>
                                        <td>{{ $slide->title }}</td>
                                        <td><img src="{{ asset('storage/'. $slide->small) }}" /></td>
                                        <td>
                                            @if ($slide->prevSlide())
                                                <a href="{{ url('admin/slides/'. $slide->id .'/up') }}">up</a>
                                            @else
                                                up
                                            @endif
                                             | 
                                            @if ($slide->nextSlide())
                                                <a href="{{ url('admin/slides/'. $slide->id .'/down') }}">down</a>
                                            @else
                                                down
                                            @endif
                                        </td>
                                        <td>{{ $slide->status }}</td>
                                        <td>
                                            @can('edit_slides')
                                                <a href="{{ url('admin/slides/'. $slide->id .'/edit') }}" class="btn btn-warning btn-sm">edit</a>
                                            @endcan

                                            @can('delete_slides')
                                                {!! Form::open(['url' => 'admin/slides/'. $slide->id, 'class' => 'delete', 'style' => 'display:inline-block']) !!}
                                                {!! Form::hidden('_method', 'DELETE') !!}
                                                {!! Form::submit('remove', ['class' => 'btn btn-danger btn-sm']) !!}
                                                {!! Form::close() !!}
                                            @endcan
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6">No records found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        {{ $slides->links() }}
                    </div>

                    @can('add_slides')
                        <div class="card-footer text-right">
                            <a href="{{ url('admin/slides/create') }}" class="btn btn-primary">Add New</a>
                        </div>
                    @endcan
                </div>
            </div>
        </div>
    </div>
@endsection