<!-- Button trigger modal -->
<button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#lessonsModal" title="Lista">
    <i class="fas fa-list"></i>
</button>

<!-- Modal -->
<div class="modal fade" id="lessonsModal" tabindex="-1" aria-labelledby="lessonsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lessonsModalLabel">Aulas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @foreach ($modules as $module)
                    @if ($module->lessons->count() > 0)
                        <h5 class="badge badge-primary">{{ $module->name }}</h5>
                        <ul class="list-group">
                            @foreach ($module->lessons->sortBy('position') as $lesson_item)
                                @if ($lesson->id == $lesson_item->id)
                                    <li class="list-group-item">
                                        <i class="fas fa-eye text-{{ $lesson_item->isWatched() ? 'primary' : 'secondary' }}"></i>
                                        <span class="text-primary">{{ $lesson_item->name }}</span>
                                        <i class="fas fa-arrow-left text-success"></i>
                                    </li>
                                @else
                                    <a class="list-group-item list-group-item-action"
                                        href="{{ route('lessons.show', $lesson_item) }}">
                                        <i class="fas fa-eye text-{{ $lesson_item->isWatched() ? 'primary' : 'secondary' }}"></i>
                                        {{ $lesson_item->name }}
                                        @if ($lesson->id == $lesson_item->id)
                                            <i class="fas fa-arrow-left text-success"></i>
                                        @endif
                                    </a>
                                @endif
                            @endforeach
                        </ul>
                    @endif
                @endforeach
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
            </div>
        </div>
    </div>
</div>
