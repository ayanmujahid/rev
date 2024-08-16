@if(count($user->children)>0)
<li>
<span class="caret">{{$user->name}}</span>
    <ul class="treenested">
        @foreach($user->children as $child)
            @include('frontend.layout.extends.treerow', [
                'user' => $child
            ])
        @endforeach
    </ul>
</li>
@else
<li>{{$user->name}}</li>
@endif