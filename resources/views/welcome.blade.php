<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Livros - Painel de Livros</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <!-- Navegação -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="index.html">
                <i class="bi bi-book me-2 fs-4"></i>
                Painel de Livros
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="index.html">Início</a></li>
                    <li class="nav-item"><a class="nav-link active" href="books.html">Livros</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Conteúdo Principal -->
    <div class="container py-5">
        <!-- Cabeçalho -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="mb-1">Coleção de Livros</h1>
                <p class="text-muted mb-0">Gerencie sua biblioteca de livros</p>
            </div>
            <a href="book-create.html" class="btn btn-primary btn-lg">
                + Adicionar Novo Livro
            </a>
        </div>

        <!-- Tabela de Livros -->
        <div class="card shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th scope="col">Livro</th>
                            <th scope="col">Autor</th>
                            <th scope="col">Gênero</th>
                            <th scope="col">Publicação</th>
                            <th scope="col">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Linha 1 -->
                        <tr>
                            <td>
                                <div class="fw-medium">O Grande Gatsby</div>
                            </td>
                            <td>F. Scott Fitzgerald</td>
                            <td><span class="badge bg-primary bg-opacity-10 text-primary">Ficção</span></td>
                            <td class="text-muted">1925</td>
                            <td>
                                <a href="book-view.html" class="btn btn-sm btn-outline-primary me-1">Ver</a>
                                <a href="book-create.html" class="btn btn-sm btn-outline-success me-1">Editar</a>
                                <button class="btn btn-sm btn-outline-danger">Excluir</button>
                            </td>
                        </tr>
                        <!-- Linha 2 -->
                        <tr>
                            <td>
                                <div class="fw-medium">A Sangue Frio</div>
                            </td>
                            <td>Harper Lee</td>
                            <td><span class="badge bg-primary bg-opacity-10 text-primary">Ficção</span></td>
                            <td class="text-muted">1960</td>
                            <td>
                                <a href="book-view.html" class="btn btn-sm btn-outline-primary me-1">Ver</a>
                                <a href="book-create.html" class="btn btn-sm btn-outline-success me-1">Editar</a>
                                <button class="btn btn-sm btn-outline-danger">Excluir</button>
                            </td>
                        </tr>
                        <!-- Linha 3 -->
                        <tr>
                            <td>
                                <div class="fw-medium">1984</div>
                            </td>
                            <td>George Orwell</td>
                            <td><span class="badge bg-primary bg-opacity-10 text-primary">Distopia</span></td>
                            <td class="text-muted">1949</td>
                            <td>
                                <a href="book-view.html" class="btn btn-sm btn-outline-primary me-1">Ver</a>
                                <a href="book-create.html" class="btn btn-sm btn-outline-success me-1">Editar</a>
                                <button class="btn btn-sm btn-outline-danger">Excluir</button>
                            </td>
                        </tr>
                        <!-- Linha 4 -->
                        <tr>
                            <td>
                                <div class="fw-medium">Harry Potter e a Pedra Filosofal</div>
                            </td>
                            <td>J.K. Rowling</td>
                            <td><span class="badge bg-primary bg-opacity-10 text-primary">Fantasia</span></td>
                            <td class="text-muted">1997</td>
                            <td>
                                <a href="book-view.html" class="btn btn-sm btn-outline-primary me-1">Ver</a>
                                <a href="book-create.html" class="btn btn-sm btn-outline-success me-1">Editar</a>
                                <button class="btn btn-sm btn-outline-danger">Excluir</button>
                            </td>
                        </tr>
                        <!-- Linha 5 -->
                        <tr>
                            <td>
                                <div class="fw-medium">Orgulho e Preconceito</div>
                            </td>
                            <td>Jane Austen</td>
                            <td><span class="badge bg-primary bg-opacity-10 text-primary">Romance</span></td>
                            <td class="text-muted">1813</td>
                            <td>
                                <a href="book-view.html" class="btn btn-sm btn-outline-primary me-1">Ver</a>
                                <a href="book-create.html" class="btn btn-sm btn-outline-success me-1">Editar</a>
                                <button class="btn btn-sm btn-outline-danger">Excluir</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Paginação -->
            <div class="card-footer d-flex justify-content-between align-items-center bg-light">
                <span class="text-muted">Mostrando 1 a 5 de 24 resultados</span>
                <nav>
                    <ul class="pagination pagination-sm mb-0">
                        <li class="page-item disabled"><a class="page-link" href="#">Anterior</a></li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">Próximo</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>