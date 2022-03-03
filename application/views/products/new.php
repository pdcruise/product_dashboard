<div class="col-10 offset-1 mt-4 p-4">
    <div class="col-md-12 d-flex mb-4">
        <h3>Add a new Product</h3>
        <a href="<?=base_url().'dashboard'?>" class="ms-auto"><button type="button" class="btn btn-primary">Return to Dashboard</button></a>
    </div>
    <div class="col-4 offset-4">
    <?= form_open('products/process_new_product', 'class="row g-3"') ?>
        <span class="text-success reset"><?= !empty($message) ? $message : "" ?></span>
        <div class="form-group">
            <label for="name">Name: </label>
            <input type="text" id="name" class="form-control" name="name" placeholder="Item Name" value="<?= set_value('name'); ?>">
            <span class="text-danger reset"><?= form_error('name')?></span>
        </div>
        <div class="form-group">
            <label for="description">Description: </label>
            <textarea name="description" id="description" class="form-control" cols="30" rows="10"><?= set_value('description'); ?></textarea>
            <span class="text-danger reset"><?= form_error('description')?></span>
        </div>
        <div class="form-group">
            <label for="price">Price: </label>
            <input type="text" id="price" class="form-control" name="price" placeholder="Price" >
            <span class="text-danger reset"><?= form_error('price')?></span>
        </div>
        <div class="form-group">
            <label for="count">Inventory Count: </label>
            <input type="number" id="count" class="form-control" name="count" value="1">
            <span class="text-danger reset"><?= form_error('count')?></span>
        </div>
        <div>
            <button type="submit" class="btn btn-success float-end">Create</button>
        </div>
    <?= form_close() ?>
    </div>
</div>