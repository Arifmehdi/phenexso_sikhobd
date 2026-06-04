<table class="table table-sm table-bordered table-striped">
    <thead>
        <tr>
            <th width="20">SL</th>
            <th width="100">Action</th>
            <th>Name</th>
            <th>Email</th>
            <th>Subject</th>
            <th>Received At</th>
        </tr>
    </thead>
    <tbody>
        @php $i = (($contacts->currentPage() - 1) * $contacts->perPage() + 1); @endphp
        @foreach($contacts as $contact)
        <tr>
            <td>{{ $i++ }}</td>
            <td>
                <div class="dropdown show">
                    <a class="btn btn-primary btn-xs dropdown-toggle" href="#" role="button" id="dropdownMenuLink{{ $contact->id }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuLink{{ $contact->id }}">
                        <a class="dropdown-item" href="{{ route('admin.contacts.show', $contact->id) }}"><i class="fas fa-eye"></i> View</a>
                        <form action="{{ route('admin.contacts.destroy', $contact->id) }}" method="POST" onsubmit="return confirm('Are you sure?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="dropdown-item text-danger"><i class="fa fa-trash"></i> Delete</button>
                        </form>
                    </div>
                </div>
            </td>
            <td>{{ $contact->name }}</td>
            <td>{{ $contact->email }}</td>
            <td>{{ $contact->subject }}</td>
            <td>{{ $contact->created_at->format('d M, Y h:i A') }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="px-2">
    {{ $contacts->links() }}
</div>