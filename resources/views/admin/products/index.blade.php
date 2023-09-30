<x-admin-layout title="Products">
    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Category</th>
            <th>Status</th>
            <th>Created At</th>
            <th>Image</th>
            <th colspan="2">Options</th>
        </tr>
        </thead>
        <tbody>

        @forelse($products as $product)

            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$product->name}}</td>
                <td><a href="{{route('admin.categories.show',$product->category->id)}}">{{$product->category->name}}</a>
                </td>
                <td>{{$product->status}}</td>

                <td>{{ $product->created_at->format('Y-m-d') }}</td>
                <td><img src="{{$product->image_url}}" alt="" height="50"></td>
                <td>
                    <a href="{{route('admin.products.edit',$product->id)}}"
                       class="btn btn-sm btn-outline-success">Edit</a>
                </td>
                <td>
                    <form action="{{route('admin.products.destroy',$product->id)}}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td class="text-center text-danger text-lg text-bold" colspan="9">No products defined</td>
            </tr>
        @endforelse
        </tbody>
    </table>
    <div class="text-center">
        {{$products->links()}}
    </div>
</x-admin-layout>
