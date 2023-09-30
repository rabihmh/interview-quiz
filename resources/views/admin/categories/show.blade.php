<x-admin-layout title="Category - {{$category->slug}}">
    <h2 class="text-center mb-4">List Products of {{$category->name}} </h2>
    <table class="table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Status</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Image</th>
            <th>Created At</th>
        </tr>
        </thead>
        <tbody>
        @forelse($category->products as $product)

            <tr>
                <td>{{$loop->iteration}}</td>
                <td>{{$product->name}}</td>
                <td>{{$product->status}}</td>
                <td>{{$product->price}}</td>
                <td>{{$product->quantity}}</td>
                <td><img src="{{$product->image_url}}" height="100"></td>
                <td>{{$product->created_at}}</td>

            </tr>
        @empty
            <tr>
                <td class="text-center text-danger text-lg text-bold" colspan="9">No products defined</td>
            </tr>
        @endforelse
        </tbody>
    </table>

</x-admin-layout>
