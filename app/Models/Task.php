<?php

namespace App\Models;

use Database\Factories\TaskFactory;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 *
 *
 * @property int         $id
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property string|null $description
 * @property bool        $is_done
 * @property int         $position
 * @method static TaskFactory factory($count = null, $state = [])
 * @method static Builder<static>|Task newModelQuery()
 * @method static Builder<static>|Task newQuery()
 * @method static Builder<static>|Task query()
 * @method static Builder<static>|Task whereCreatedAt($value)
 * @method static Builder<static>|Task whereDescription($value)
 * @method static Builder<static>|Task whereId($value)
 * @method static Builder<static>|Task whereIsDone($value)
 * @method static Builder<static>|Task whereUpdatedAt($value)
 * @method static Builder<static>|Task wherePosition($value)
 * @mixin Eloquent
 */
class Task extends Model
{
    /** @use HasFactory<TaskFactory> */
    use HasFactory;

    protected $casts = [
        'is_done' => 'boolean',
    ];

    protected $fillable = [
        'description',
        'is_done',
        'position',
    ];

    protected static function booted(): void
    {
        static::creating(static function (Task $task) {
            $task->position = Task::max('position') + 1;
        });

        static::updated(static function (Task $task) {
            if ($task->isDirty('position')) {
                $oldPosition = $task->getOriginal('position');
                $newPosition = $task->getAttribute('position');

                if ($oldPosition > $newPosition) {
                    Task::where('position', '<', $oldPosition)
                        ->where('position', '>=', $newPosition)
                        ->where('id', '!=', $task->id)
                        ->increment('position');
                } else {
                    Task::where('position', '>', $oldPosition)
                        ->where('position', '<=', $newPosition)
                        ->where('id', '!=', $task->id)
                        ->decrement('position');
                }
            }
        });

        static::deleted(static function (Task $task) {
            Task::where('position', '>', $task->getOriginal('position'))
                ->decrement('position');
        });
    }
}
