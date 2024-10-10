<?php

namespace App\Http\Controllers;

use App\Http\Requests\AlbumMemberRequest;
use App\Models\AlbumMember;
use App\Services\AlbumMemberService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Inertia\Inertia;

class AlbumMemberController extends Controller
{
    use AuthorizesRequests;
    private AlbumMemberService $albumMember;

    public function __construct(AlbumMemberService $albumMember)
    {
        $this->albumMember = $albumMember;
    }

    public function store(AlbumMemberRequest $request)
    {
        $this->authorize('create', AlbumMember::class);

        $this->albumMember->addMember($request);

        return response(null, 200);
    }

    public function show(AlbumMember $albumMember)
    {
        $this->authorize('view', $albumMember);

        return $albumMember;
    }

    public function update(AlbumMemberRequest $request, AlbumMember $albumMember)
    {
        $this->authorize('update', $albumMember);

        $albumMember->update($request->validated());

        return $albumMember;
    }

    public function destroy(AlbumMember $albumMember)
    {
        $this->authorize('delete', $albumMember);

        $albumMember->delete();

        return response()->json();
    }
}
