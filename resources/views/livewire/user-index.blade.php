<div>
    <table class="w-full table-auto">
        <tr>
            <th class="border px-4 py-2 text-left">Name</th>
            <th class="border px-4 py-2 text-left">Email</th>
            <th class="border px-4 py-2 text-left">Permission</th>
            <th class="border px-4 py-2">Actions</th>
        </tr>
        @foreach ($users as $user)
            <tr>
                <td class="border px-4 py-2">{{ $user->name }}</td>
                <td class="border px-4 py-2">{{ $user->email }}</td>
                <td class="border px-4 py-2">
                    <div class="flex items-center gap-4 flex-wrap">
                        @foreach($user->roles as $role)
                            <p class="text-sm py-1 px-2 font-medium text-white bg-green-500 rounded">{{$role->name}}</p>
                        @endforeach
                    </div>
                </td>
                <td class="border px-4 py-2 text-center">
                    <div class="flex items-center justify-center">
                        <a class="mr-2" href="{{ route('user.edit', $user->id) }}">
                            @include('components.icons.edit')
                        </a>

                        <form class="ml-1 inline-block" onsubmit="return confirm('Are you sure?');"
                            wire:submit.prevent="userDelete({{ $user->id }})">
                            <button type="submit">
                                @include('components.icons.trash')
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @endforeach
    </table>

    <div class="mt-4">
        {{ $users->links() }}
    </div>
</div>
