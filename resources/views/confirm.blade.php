<form action="{{action('ContactController@process')}}" method="post">

{{$contact->name}}

{{$contact->email}}

{{$contact->message}}

<input type="submit" name="action" value="back">

<input type="submit" name="action" value="submit">

@foreach($contact->getAttributes() as $key => $value)
<input type="hidden" name="{{$key}}" value="{{$value}}">
@endforeach
</form>