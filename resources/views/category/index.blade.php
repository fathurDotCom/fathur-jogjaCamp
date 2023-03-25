@extends('layouts.app')
@section('title')
    Category
@endsection
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Category</h3>
        </div>
        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-12 text-end">
                    <a href="{{ route('category.create') }}" class="btn btn-primary">Add Category</a>
                </div>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Name</th>
                        <th>Publish</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($categories as $category)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->is_publish ? 'Yes' : 'No' }}</td>
                            <td>{{ $category->created_at }}</td>
                            <td>{{ $category->updated_at }}</td>
                            <td>
                                <a href="{{ route('category.edit', $category->id) }}" class="btn btn-sm btn-warning">Edit</a>
                                <form action="{{ route('category.destroy', $category->id) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this category?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No data found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="d-flex justify-content-center">
                {{-- {{ $categories->links() }} --}}
            </div>
        </div>
    </div>
@endsection

@push('css')
    <link href="//cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet">
@endpush

@push('js')
<script src="//cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script>
    let table = $('.table').DataTable();
</script>
@endpush
