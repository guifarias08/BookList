@php
    $editing = isset($book) && $book;
    $selectedStatus = old('status', $editing ? $book->status : 'want_to_read');
@endphp

<form action="{{ $action }}" method="POST" enctype="multipart/form-data" class="book-form">
    @csrf
    @if(($method ?? 'POST') !== 'POST')
        @method($method)
    @endif

    <div class="cover-area">
        <div class="cover-preview" id="coverPreview" aria-live="polite">
            @if($editing && $book->cover)
                <img src="{{ asset('storage/' . $book->cover) }}" alt="Capa atual de {{ $book->title }}">
            @else
                <div class="cover-placeholder">
                    <strong aria-hidden="true">B</strong>
                    <span>{{ $editing ? 'Sem capa' : 'Prévia da capa' }}</span>
                </div>
            @endif
        </div>

        <div class="cover-upload">
            <label for="cover">{{ $editing ? 'Alterar capa' : 'Capa do livro' }}</label>
            <input type="file"
                   id="cover"
                   name="cover"
                   accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                   aria-describedby="coverHint">
            <small id="coverHint" data-default-text="{{ $editing ? 'Deixe vazio para manter a capa atual. JPG, PNG ou WEBP até 2 MB.' : 'JPG, PNG ou WEBP até 2 MB.' }}">
                {{ $editing ? 'Deixe vazio para manter a capa atual. JPG, PNG ou WEBP até 2 MB.' : 'JPG, PNG ou WEBP até 2 MB.' }}
            </small>
            @error('cover') <small class="field-error">{{ $message }}</small> @enderror
        </div>
    </div>

    <div class="form-grid">
        <div class="field full">
            <label for="title">Título <span aria-hidden="true">*</span></label>
            <input type="text" id="title" name="title"
                   value="{{ old('title', $editing ? $book->title : '') }}"
                   placeholder="Ex.: Dom Casmurro" autocomplete="off" required>
            @error('title') <small class="field-error">{{ $message }}</small> @enderror
        </div>

        <div class="field">
            <label for="author">Autor <span aria-hidden="true">*</span></label>
            <input type="text" id="author" name="author"
                   value="{{ old('author', $editing ? $book->author : '') }}"
                   placeholder="Ex.: Machado de Assis" autocomplete="off" required>
            @error('author') <small class="field-error">{{ $message }}</small> @enderror
        </div>

        <div class="field">
            <label for="genre">Gênero</label>
            <input type="text" id="genre" name="genre"
                   value="{{ old('genre', $editing ? $book->genre : '') }}"
                   placeholder="Ex.: Romance">
        </div>

        <div class="field">
            <label for="publication_year">Ano de publicação</label>
            <input type="number" id="publication_year" name="publication_year"
                   value="{{ old('publication_year', $editing ? $book->publication_year : '') }}"
                   placeholder="Ex.: 1899" min="1000" max="{{ date('Y') }}">
        </div>

        <div class="field">
            <label for="isbn">ISBN</label>
            <input type="text" id="isbn" name="isbn"
                   value="{{ old('isbn', $editing ? $book->isbn : '') }}"
                   placeholder="Ex.: 9788532530783">
        </div>

        <div class="field">
            <label for="status">Status de leitura <span aria-hidden="true">*</span></label>
            <select name="status" id="status" required>
                <option value="want_to_read" @selected($selectedStatus === 'want_to_read')>Quero ler</option>
                <option value="reading" @selected($selectedStatus === 'reading')>Lendo</option>
                <option value="read" @selected($selectedStatus === 'read')>Concluído</option>
                <option value="paused" @selected($selectedStatus === 'paused')>Pausado</option>
                <option value="abandoned" @selected($selectedStatus === 'abandoned')>Abandonado</option>
            </select>
        </div>

        <div class="field">
            <label for="pages">Total de páginas</label>
            <input type="number" id="pages" name="pages"
                   value="{{ old('pages', $editing ? $book->pages : '') }}"
                   placeholder="Ex.: 320" min="1" max="100000">
            @error('pages') <small class="field-error">{{ $message }}</small> @enderror
        </div>

        <div class="field">
            <label for="current_page">Página atual</label>
            <input type="number" id="current_page" name="current_page"
                   value="{{ old('current_page', $editing ? ($book->current_page ?? 0) : 0) }}"
                   min="0" aria-describedby="progressHint">
            <small id="progressHint">A página atual não pode ultrapassar o total de páginas.</small>
            @error('current_page') <small class="field-error">{{ $message }}</small> @enderror
        </div>

        <div class="field full">
            <label for="description">Sinopse / Anotações</label>
            <textarea id="description" name="description" rows="6" maxlength="5000"
                      placeholder="Escreva uma sinopse, descrição ou observação...">{{ old('description', $editing ? $book->description : '') }}</textarea>
        </div>
    </div>

    <div class="form-actions">
        <a href="{{ $cancelUrl }}" class="btn btn-secondary">Cancelar</a>
        <button type="submit" class="btn btn-primary">{{ $submitLabel }}</button>
    </div>
</form>