@layout('templates.main')
@section('content')
<div class="span8">
    <h2>Ajouter un Album</h2>
    <hr />
    {{ Form::open('admin') }}
    	{{ Form::hidden('album_author', $user->id) }}
        <!-- Champ nom -->
        <p>{{ Form::label('album_name', 'Titre de l\'album') }}</p>
        {{ $errors->first('album_name', Alert::error(":message")) }}
        <p>{{ Form::text('album_name', Input::old('album_name')) }}</p>
        <!-- Champ description -->
        <p>{{ Form::label('album_body', 'Description de l\'album') }}</p>
        {{ $errors->first('album_body', Alert::error(":message")) }}
        <div>{{ Form::textarea('album_body', Input::old('album_body')) }}</div>


        <!-- Champ chanson -->
        <p>{{ Form::label('album_songs', 'Nom des chansons') }}</p>
        {{ $errors->first('album_songs', Alert::error(":message")) }}
        <p>{{ Form::textarea('album_songs', Input::old('album_songs')) }}</p>
        <!-- Champ Prix -->
        <p>{{ Form::label('album_price', 'Prix de l\'album') }}</p>
        {{ $errors->first('album_price', Alert::error(":message")) }}
        <p>{{ Form::textarea('album_price', Input::old('album_price')) }}</p>
        <!-- Champ quantitées -->
        <p>{{ Form::label('album_quantity', 'Quantitée de l\'album') }}</p>
        {{ $errors->first('album_quantity', Alert::error(":message")) }}
        <p>{{ Form::textarea('album_quantity', Input::old('album_quantity')) }}</p>
        <!-- Champ quantitées -->
        <p>{{ Form::label('album_tags', 'Tags de l\'album') }}</p>
        {{ $errors->first('album_tags', Alert::error(":message")) }}
        <p>{{ Form::textarea('album_tags', Input::old('album_tags')) }}</p>

        <!-- submit button -->
        <p>{{ Form::submit('Create') }}</p>
    {{ Form::close() }}
</div>
@endsection