<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GudangKu - Product Management</title>
    <link rel="stylesheet" href="/assets/product.css">
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
            <!-- Tampilkan nama kategori jika sedang filter -->
            <h2>Product <?php echo $categoryName ? '- ' . htmlspecialchars($categoryName) : ''; ?></h2>
            
            <?php if ($categoryName): ?>
                <p class="category-info">
                    Showing products in category: <strong><?php echo htmlspecialchars($categoryName); ?></strong>
                    <a href="/?r=product" class="clear-filter">
                        <i class="fas fa-times"></i> Clear Filter
                    </a>
                </p>
            <?php endif; ?>

            <!-- Action Buttons -->
            <div class="actions">
                <a href="/?r=category">
                    <button class="btn btn-secondary">
                        <i class="fas fa-arrow-left"></i> Back to Categories
                    </button>
                </a>
                <a href="/?r=productPrint">
                    <button class="btn print-product">
                        <i class="fas fa-print"></i> Print
                    </button>
                </a>
                <button class="btn add-product" onclick="openAddModal()">
                    <i class="fas fa-plus"></i> Add Product
                </button>
            </div>

            <!-- Search Form -->
            <form method="get" class="search-form" action="/?r=product">
                <?php if (isset($_GET['category_id'])): ?>
                    <input type="hidden" name="category_id" value="<?php echo htmlspecialchars($_GET['category_id']); ?>">
                <?php endif; ?>
                <input type="text" name="q" value="<?php echo htmlspecialchars($_GET['q'] ?? ''); ?>" placeholder="Search product...">
                <button type="submit" class="search-btn"><i class="fas fa-search"></i> Search</button>
            </form>

            <!-- Sort Options -->
            <div class="sort-options">
                <label>Sort: A - Z</label>
            </div>

            <!-- Product Table -->
            <table class="product-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Product</th>
                        <th>Code</th>
                        <th>Stock</th>
                        <th>Category</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($products)): ?>
                        <tr>
                            <td colspan="6" class="no-data">No products found in this category</td>
                        </tr>
                    <?php else: ?>
                        <?php $no = 1; foreach ($products as $product): ?>
                            <tr>
                                <td><?php echo $no++; ?></td>
                                <td><?php echo htmlspecialchars($product['name_product']); ?></td>
                                <td><?php echo htmlspecialchars($product['code']); ?></td>
                                <td><?php echo htmlspecialchars($product['stock']); ?></td>
                                <td><?php echo htmlspecialchars($product['name_category'] ?? 'N/A'); ?></td>
                                <td>
                                    <a href="javascript:void(0);" class="edit-product" onclick="openEditModal(<?php echo $product['id']; ?>)">
                                        <i class="fas fa-pencil-alt"></i> Edit
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>

    <!-- Success Notification -->
    <?php if (isset($_SESSION['success'])): ?>
        <div class="success-notification">
            <?php echo $_SESSION['success']; ?>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <!-- Error Notification -->
    <?php if (isset($_SESSION['error'])): ?>
        <div class="error-notification">
            <?php echo $_SESSION['error']; ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <script>
        // Success and Error notification handler
        $(document).ready(function() {
            <?php if (isset($_SESSION['success'])): ?>
                $('.success-notification').addClass('show');
                setTimeout(function() {
                    $('.success-notification').removeClass('show');
                }, 3000);
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                $('.error-notification').addClass('show');
                setTimeout(function() {
                    $('.error-notification').removeClass('show');
                }, 3000);
            <?php endif; ?>
        });
    </script>
</body>
</html>