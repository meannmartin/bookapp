<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Example Component</div>

                    <h1>{{$title}}</h1>
                    @if (count($data) > 0)
                        <ul class='list-group'>
                            @foreach($services as $service)    
                                <li class='list-group-item'>{{$service}}</li>
                            @endforeach
                        </ul>   
                    @endif
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
