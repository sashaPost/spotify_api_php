<?php

namespace App\Services;

use App\Models\Song;
use App\Models\Album;
use App\Models\Artist;
use App\Models\Playlist;
use App\Models\SpotifyToken;
use App\Models\PlaylistDuration;

class CreateIfNotService
{
    public function __construct()
    {

    }

    // specify '$track' as a stdClass object
    // change the methods provided just to array
    // and add all of them as a class properties
    public function token(
        $associatedArray,
        $userId,
        $code,
    ) 
    {
        return SpotifyToken::firstOrCreate(
        [
            'access_token' => $associatedArray['access_token']
        ],
        [
            'user_id' => $userId,
            'code' => $code,
            'expiration' => $associatedArray['expires_in'],
            'refresh_token' => $associatedArray['refresh_token'],
        ]);
    }

    public function songFromSong($track)
    {
        return Song::firstOrCreate(
            ['spotify_id' => $track->track?->id],
            [
                'name' => $track->track?->name,
                'duration_ms' => $track->track?->duration_ms,
                'spotify_url' => $track->track?->uri,
                'isrc' => $track->track?->external_ids->isrc,
                'added_at' => $track->added_at
            ]
        );
    }

    public function artistFromSong($track)
    {
        return Artist::firstOrCreate(
            ['spotify_id' => $track->track?->artists[0]->id],
            [
                'name' => $track->track?->artists[0]->name,
                'spotify_url' => $track->track?->artists[0]->external_urls->spotify
            ]
        );
    }

    public function albumFromSong($track)
    {
        $artist = Artist::where('spotify_id', $track->track?->artists[0]->id)->first();
        $artistId = $artist->id;
        return Album::firstOrCreate(
            ['spotify_id' => $track->track?->album->id],
            [
                'name' => $track->track?->album->name,
                'release_date' => $track->track?->album->release_date,
                'artist' => $track->track?->artists[0]->name,
                'spotify_url' => $track->track?->album->external_urls->spotify,
                'total_tracks' => $track->track?->album->total_tracks,
                'artist_id' => $artistId
            ]
        );
    }

    public function playlist($playlist)
    {
        return Playlist::firstOrCreate(
            ['spotify_id' => $playlist->id],
            [
                'name' => $playlist->name,
                'description' => $playlist->description,
                'spotify_url' => $playlist->external_urls->spotify,
                'collaborative' => $playlist->collaborative,
                'public' => $playlist->public,
                'total_tracks' => $playlist->tracks->total,
                'owner_id' => $playlist->owner->id
            ]
        );
    }

    public function playlistDuration($playlistId, $totalDurationMs)
    {
        return PlaylistDuration::firstOrCreate(
            ['playlist_id' => $playlistId],
            ['duration_ms' => $totalDurationMs]
        );
    }
}