<!-- Button trigger modal -->
<button type="button" class="btn btn-sm btn-primary ml-1" data-toggle="modal" data-target="#createQuestionListModal"
    title="Adicionar/Cadastrar">
    <i class="fas fa-plus"></i>
</button>

<!-- Modal -->
<div class="modal fade" id="createQuestionListModal" tabindex="-1" aria-labelledby="createQuestionListModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createQuestionListModalLabel">Cadastrar</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('reviews.store') }}" id="createQuestionListModalForm" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="modal_trigger" value="#createQuestionListModal">

                    <div class="form-group form-check">
                        <input type="radio" name="type" value="simulation" disabled>
                        <label for="type" class="form-check-label">Novo simulado</label>
                    </div>

                    <div class="form-group form-check">
                        <input type="radio" name="type" value="review" checked>
                        <label for="type" class="form-check-label">Nova revisão diária</label>
                    </div>

                    {{-- input select com número de questões --}}
                    <div class="form-group">
                        <label for="questions_number">Quantidade de questões</label>
                        <select name="questions_number" id="questions_number" class="form-control">
                            <option value="0">Sem limite</option>
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="15">15</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                        </select>
                    </div>

                    {{-- input select com tempo em minutos --}}
                    <div class="form-group">
                        <label for="duration">Duração em minutos</label>
                        <select name="duration" id="duration" class="form-control">
                            <option value="15">15 minutos</option>
                            <option value="20">20 minutos</option>
                            <option value="30">30 minutos</option>
                            <option value="60">1 hora</option>
                        </select>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                <button type="submit" class="btn btn-primary" form="createQuestionListModalForm">Cadastrar</button>
            </div>
        </div>
    </div>
</div>
