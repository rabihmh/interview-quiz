<x-admin-layout title="Categories">
    <h1 class="text-center">Categories</h1>
    <form action="{{URL::current()}}" class="d-flex justify-content-between mb-4">
        <x-form.input name="name" placeholder="Name" class="mx-2"/>
        <select name="status" class="form-control" class="mx-2">
            <option value="">All</option>
            <option value="active">Active</option>
            <option value="archived">Archived</option>
        </select>
        <button class="btn btn-sm btn btn-dark mx-2">Search</button>
    </form>
    <table class="table">
        <thead>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Parent</th>
            <th>Status</th>
            <th>Number of products</th>
            <th>Created At</th>
            <th>Image</th>
            <th colspan="2">Options</th>
        </tr>
        </thead>
        <tbody>
        @foreach($categories as $category)
            <tr>
                <th scope="row">{{$loop->iteration}}</th>
                <td><a href="{{route('admin.categories.show',$category->id)}}">{{$category->name}}</a></td>
                <td>{{$category->parent->name}}</td>
                <td>{{$category->status}}</td>
                <td>{{$category->products_count}}</td>
                <td>{{$category->created_at}}</td>
                <td><img src="{{asset('storage/'.$category->image)}}" alt="{{$category->name}}" height="50"></td>
                <td class="d-flex justify-content-between">
                    <a href="{{route('admin.categories.edit',$category->id)}}"
                       class="btn btn-sm btn-outline-success">Edit</a>
                    <form action="{{route('admin.categories.destroy',$category->id)}}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{$categories->withQueryString()->links()}}
</x-admin-layout>
