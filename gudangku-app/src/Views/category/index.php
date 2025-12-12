<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GudangKu - Inventory Management System</title>
    <link rel="stylesheet" href="/assets/category.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <header>
        <div class="logo">
            <img src="/assets/icon.png" alt="GudangKu Icon" class="logo-icon">
            <h1>GudangKu - Inventory Management System</h1>
        </div>
    </header>

    <main>
        <div class="dashboard-container">
            <h2>Category Product</h2>

            <!-- Action Buttons -->
            <div class="actions">
                <!-- Tombol Print dengan ikon -->
                <a href="/?r=print">
                    <button class="btn print-category">
                        <i class="fas fa-print"></i> Print
                    </button>
                </a>

                <!-- Tombol Add Category dengan ikon - FIXED: Hapus tag <a> -->
                <button class="btn add-category" onclick="openAddModal()">
                    <i class="fas fa-plus"></i> Add Category
                </button>
            </div>

            <!-- Search Form Styling -->
            <form method="get" class="search-form" action="/?r=category">
                <input type="text" name="q" value="<?php echo htmlspecialchars($_GET['q'] ?? ''); ?>" placeholder="Search category...">
                <button type="submit" class="search-btn"><i class="fas fa-search"></i> Search</button>
            </form>

            <!-- Modal Edit Category -->
            <div id="editCategoryModal" class="modal">
                <div class="modal-content">
                    <span class="close-btn" onclick="closeModal()">&times;</span>
                    <h3>Edit Category</h3>
                    <form id="editCategoryForm" method="post" action="/?r=catUpdate">
                        <input type="hidden" name="id" id="categoryId">
                        <div class="form-group">
                            <label for="editCategoryName">Name Category</label>
                            <input type="text" name="name" id="editCategoryName" required placeholder="Enter category name">
                        </div>
                        <div class="modal-buttons">
                            <button type="button" class="cancel-btn" onclick="closeModal()">Cancel</button>
                            <button type="submit" class="update-btn">Update</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Modal Add Category -->
            <div id="addCategoryModal" class="modal">
                <div class="modal-content">
                    <span class="close-btn" onclick="closeAddModal()">&times;</span>
                    <h3>Add New Category</h3>
                    <form id="addCategoryForm" method="post" action="/?r=catCreate">
                        <div class="form-group">
                            <label for="addCategoryName">Category Name</label>
                            <input type="text" name="name" id="addCategoryName" required placeholder="Enter new category name">
                        </div>
                        <div class="modal-buttons">
                            <button type="button" class="cancel-btn" onclick="closeAddModal()">Cancel</button>
                            <button type="submit" class="add-btn">Add Category</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Category List -->
            <ul class="category-list">
                <?php foreach ($categories as $category): ?>
                    <li class="category-item">
                        <span class="category-name"><?php echo htmlspecialchars($category['name_category']); ?></span>
                        <a href="javascript:void(0);" class="edit-category" onclick="openModal(<?php echo $category['id']; ?>, '<?php echo htmlspecialchars($category['name_category']); ?>')">
                            <i class="fas fa-pencil-alt"></i>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </main>


    <script>
        // Fungsi untuk membuka modal Edit dan mengisi input dengan data kategori yang dipilih
        function openModal(id, name) {
            document.getElementById('editCategoryModal').style.display = 'block';
            document.getElementById('categoryId').value = id;
            document.getElementById('editCategoryName').value = name;
        }

        // Fungsi untuk menutup modal Edit
        function closeModal() {
            document.getElementById('editCategoryModal').style.display = 'none';
        }

        // Fungsi untuk membuka modal Add Category
        function openAddModal() {
            document.getElementById('addCategoryModal').style.display = 'block';
        }

        // Fungsi untuk menutup modal Add Category
        function closeAddModal() {
            document.getElementById('addCategoryModal').style.display = 'none';
        }

        // Menutup modal ketika klik di luar modal
        window.onclick = function(event) {
            const editModal = document.getElementById('editCategoryModal');
            const addModal = document.getElementById('addCategoryModal');
            
            if (event.target === editModal) {
                closeModal();
            }
            if (event.target === addModal) {
                closeAddModal();
            }
        }
    </script>
</body>
</html>