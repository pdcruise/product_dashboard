<div class="col-10 offset-1 mt-4 p-4">
    <h1><?= $item['name'] ?></h1>
    <p>Added Since: <?= date_format(new DateTime($item['added_since']), 'F jS Y') ?></p>
    <p>Product ID: <?= $item['id'] ?></p>
    <p>Description: <?= $item['description'] ?></p>
    <p>Total Sold: <?= $item['sold'] ?></p>
    <p>Number of available stocks: <?= $item['inventory_count'] ?></p>

    <h4>Leave a Review</h4>
    <?= form_open('products/review/'.$item['id'].'', 'class="row g-3"') ?>
        <div class="form-group">
            <textarea name="review" id="review" class="form-control" cols="30" rows="5"></textarea>
            <span class="reset text-danger"><?= form_error('review') ?></span>
            <span class="reset text-danger"><?= form_error('message') ?></span>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-success float-end mb-2">Post Review</button>
        </div>
    <?= form_close() ?>
<?php   foreach ($contents as $review)
        {
?>          <div>
                <span class="fw-bolder"><?= $review['name'] ?></span> wrote:
                <span class="float-end"><?= date_format(new DateTime($review['created_at']), 'F jS Y') ?></span>
                <!-- <span class="float-end"><?= date_diff( new DateTime(), new DateTime($review['created_at']))->format('%a days %h hours %i Minutes') ?></span> -->
                <p><?= $review['review'] ?></p>
            </div>
<?php       foreach ($review['messages'] as $message)
            {
?>              <div class="col-10 offset-2">
                <span class="fw-bolder"><?= $message['name'] ?></span> wrote:
                <span class="float-end"><?= date_format(new DateTime($message['created_at']), 'F jS Y') ?></span>
                <p><?= $message['message'] ?></p>
                </div>
<?php       }
?>
            <?= form_open('products/message/'.$review['review_id'].'/'.$item['id'].'', 'class="row g-3 col-10 offset-2"') ?>
                <div class="form-group">
                    <textarea name="message" id="message" class="form-control" cols="30" rows="3"></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-success float-end mb-4">Post Message</button>
                </div>
            <?= form_close() ?>
<?php   }
?>
</div>
