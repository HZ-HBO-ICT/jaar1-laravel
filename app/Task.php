<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * Class Task
 * @package App
 *
 * @property int id
 * @property string title
 * @property string body
 * @property int state
 * @property int rating
 * @property int hours_planned
 * @property int progress
 *
 * @property \App\Task parent
 * @property Collection children
 *
 * @property boolean has_children
 */
class Task extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'body', 'hours_planned'
    ];

    /**
     * Returns the children of this task
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany('App\Task', 'parent_id');
    }

    /**
     * Returns the parent task of this task. Might be null if this task is a master task
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo('App\Task', 'parent_id');
    }


    /*
     * hours_planned, progress and derived properties are computed once for performance reasons.
     * Because of this, children() is only called once.
     *
     */
    private $cache_initialized = false;

    private $cached_has_children = null;
    private $cached_state = null;
    private $cached_hours_planned = null;
    private $cached_progress = null;
    private $cached_hours_actual = null;
    private $cached_hours_remaining = null;

    private function init_cache()
    {
        $this->cached_has_children = $this->children()->count() > 0;

        $planned = $this->attributes['hours_planned'];
        $progress = $this->attributes['progress'];
        $state = $this->attributes['state'];


        if ($this->cached_has_children)
        {
            $planned = 0;
            $actual = 0;
            $allChildrenToDo = true;
            $allChildrenOnHold = true;
            $allChildrenDone = true;
            foreach ($this->children as $child)
            {
                $planned += $child->hours_planned;
                $actual += $child->progress / 100.0 * $child->hours_planned;
                $allChildrenToDo &= $child->state == 0;
                $allChildrenOnHold &= $child->state == 2;
                $allChildrenDone &= $child->state == 3;
            }
            if ($allChildrenToDo)
                $state = 0;
            else if ($allChildrenDone)
                $state = 3;
            else if ($allChildrenOnHold)
                $state = 2;
            else
                $state = 1;

            if ($planned == 0)
                $progress = 0;
            else
                $progress = 100.0 * $actual / $planned;
        }

        $this->cached_state = $state;

        $this->cached_hours_planned = round($planned);

        switch ($state) {
            case 0:
                $this->cached_progress = 0;
                break;
            case 1:
            case 2:
                $this->cached_progress = round($progress,1);
                break;
            case 3:
                $this->cached_progress = 100;
                break;
        }

        $this->cached_hours_actual = round($this->cached_hours_planned * $this->cached_progress / 100.0);
        $this->cached_hours_remaining = round($this->cached_hours_planned - $this->cached_hours_actual);

        $this->cache_initialized = true;
    }

    public function getHasChildrenAttribute()
    {
        if ( !$this->cache_initialized) {
            $this->init_cache();
        }
        return $this->cached_has_children;
    }

    public function getStateAttribute()
    {
        if ( !$this->cache_initialized) {
            $this->init_cache();
        }
        return $this->cached_state;
    }

    public function getProgressAttribute()
    {
        if ( !$this->cache_initialized) {
            $this->init_cache();
        }
        return $this->cached_progress;
    }

    public function getHoursPlannedAttribute()
    {
        if ( !$this->cache_initialized) {
            $this->init_cache();
        }
        return $this->cached_hours_planned;
    }

    public function getHoursActualAttribute()
    {
        if ( !$this->cache_initialized) {
            $this->init_cache();
        }
        return $this->cached_hours_actual;
    }

    public function getHoursRemainingAttribute()
    {
        if ( !$this->cache_initialized) {
            $this->init_cache();
        }
        return $this->cached_hours_remaining;
   }

}
