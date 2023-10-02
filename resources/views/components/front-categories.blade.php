<div class="mega-category-menu">
    <span class="cat-button"><i class="lni lni-menu"></i>All Categories</span>
    <ul class="sub-category">
        @foreach($categories->where('parent_id', null) as $category)
            <li>
                <a href="{{route('front.products.by.category',$category->id)}}">{{$category->name}} <i class="lni lni-chevron-right"></i></a>
                @if($categories->where('parent_id', $category->id)->isNotEmpty())
                    <ul class="inner-sub-category">
                        @foreach($categories->where('parent_id', $category->id) as $childCategory)
                            <li><a href="{{route('front.products.by.category',$childCategory->id)}}">{{$childCategory->name}}</a></li>
                        @endforeach
                    </ul>
                @endif
            </li>
        @endforeach
    </ul>
</div>

