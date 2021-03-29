<div class="bg-info d-flex align-items-center justify-content-between text-white py-1 px-2 small mb-2">
    <span>{{ $slot }}</span>
    <form method="post" action="{{ route('user.revokerole') }}">
        @method('DELETE')
        @csrf
        <input type="hidden"
               name="role_id"
               id="role_id"
               value="{{ $role->id }}"
        >
        <input type="hidden"
               name="user_id"
               id="user_id"
               value="{{ $user->id }}"
        >
        <button class="btn btn-sm">
            <i class="far fa-trash-alt text-white"></i>
        </button>
    </form>
</div>
