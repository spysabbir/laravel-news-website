<div class="card">
    <div class="card-header">
        <h4 class="card-title">{{ $contact_message->name }}</h4>
        <p class="card-text">{{ $contact_message->email }}</p>
        <p class="card-text">{{ $contact_message->created_at->format('D d-M,Y h:m:s A') }}</p>
    </div>
    <div class="card-body">
        <strong>{{ $contact_message->subject }}</strong>
        <p>{{ $contact_message->message }}</p>
    </div>
</div>
