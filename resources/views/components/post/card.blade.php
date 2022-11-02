
    <x-card>
        <x-card-body> 
            <h5>
                <a href="{{ route('blog.show', $post->id) }}">

                {{$post->title}}
                
                </a>
            </h5>
            
            <div class="small text-muted">
                {{now()->format('d.m.y H:i:s')}}
            </div>

        </x-card.body>
    </x-card>

