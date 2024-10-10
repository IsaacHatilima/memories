<?php

namespace App\Http\Controllers;

use App\Http\Requests\AlbumRequest;
use App\Http\Requests\UpdateAlbumRequest;
use App\Models\Album;
use App\Services\AlbumService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class AlbumController extends Controller
{
    use AuthorizesRequests;
    private AlbumService $albumService;

    public function __construct(AlbumService $albumService)
    {
        $this->albumService = $albumService;
    }

    public function index()
    {
        $this->authorize('viewAny', Album::class);

        $albums = Album::all();

        return Inertia::render('Album/Index', ['albums' => $albums]);
    }

    public function show(Album $album)
    {
        $this->authorize('viewAny', Album::class);

        $album->load('user', 'members');


        return Inertia::render('Album/AlbumDetails', [
            'album' => $album,
            'members' => $album->members
        ]);
    }

    public function trashed()
    {
        $this->authorize('view', Album::class);

        $trashedAlbums = Album::onlyTrashed()->get();

        return Inertia::render('Album/Index', ['albums' => $trashedAlbums]);
    }

    public function store(AlbumRequest $request)
    {
        $this->authorize('create', Album::class);

        $this->albumService->createAlbum($request);

        return response(null, 200);
    }

    public function update(UpdateAlbumRequest $request, Album $album)
    {
        $this->authorize('update', $album);

        $this->albumService->updateAlbum($request, $album);

        return Redirect::route('albums.index');
    }

    public function destroy($public_id)
    {
        $album = Album::withTrashed()->where('public_id', $public_id)->first();

        if (!$album) {
            return response([], 404);
        }

        $this->authorize('forceDelete', $album);

        $album->forceDelete();

        return Redirect::route('albums.index');
    }

    public function archive(Album $album)
    {
        $this->authorize('delete', $album);

        $album->delete();

        return Redirect::route('albums.index');
    }

    public function restore( $public_id)
    {
        $album = Album::withTrashed()->where('public_id', $public_id)->first();

        if (!$album) {
            return response()->json([], 404);
        }

        $this->authorize('restore', $album);

        $album->restore();

        return Redirect::route('albums.trashed');
    }
}
