<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Song extends Model
{
    use HasFactory;

    public function artist() 
    {
        return $this->belongsTo('App/Artist', 'artist_id');
    }

    public function album()
    {
        return $this->belongsTo('App/Album', 'album_id');
    }

    public function playlists()
    {
        return $this->belongsToMany('App\Playlist', 'song_playlists', 'song_id', 'playlist_id');
    }

    public function users()
    {
        return $this->belongsToMany('App\User', 'song_users', 'song_id', 'user_id');
    }
}
