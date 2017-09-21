<?php
$comment_args = array(
    'class_form' => 'form-horizontal',
    'id_submit' => 'submit',
    'title_reply' => __('Leave a Reply'),
    'title_reply_to' => __('Leave a Reply to %s'),
    'cancel_reply_link' => __('Cancel Reply'),
    'label_submit' => __('コメントを送信'),
    'class_submit' => 'btn btn-primary',
    'title_reply' => '<i class="fa fa-commenting-o"></i> コメントをどうぞ',
    'comment_notes_before' => '<div class="comment-notes"><div class="email-notes">メールアドレスが公開されることはありません。</div></div>',
    'fields' => apply_filters('comment_form_default_fields', array(
        'author' => '<div class="form-group"><label class="sr-only" for="author">' . __('氏名') . '</label> ' .
        '<div class="col-md-5"><input type="text" class="form-control" name="author" required id="author" value="' . esc_attr($commenter['comment_author']) . '" tabindex="1" placeholder="氏名" aria-required="true" /></div></div>',
        'email' => '<div class="form-group">' .
        '<label class="sr-only" for="email">メールアドレス</label>' .
        '<div class="col-md-5"><input type="email" class="form-control" name="email" required id="email" value="' . esc_attr($commenter['comment_author_email']) . '" tabindex="2" placeholder="メールアドレス" aria-required="true" /></div></div>',
        'url' => '<div class="form-group"><label class="sr-only" for="url">ホームページ</label>
				    <div class="col-md-5">
					<input type="text" class="form-control" name="url" id="url" value="' . esc_attr(@$commenter['comment_url']) . '" tabindex="3" placeholder="ホームページ">
					</div></div>')),
    'comment_field' => '<div class="form-group"><label class="sr-only" for="comment">コメント</label><div class="col-md-10">' .
    '<textarea class="form-control input-lg" name="comment" id="comment" rows="6" tabindex="4" required placeholder="コンテンツ..."></textarea></div></div>',
    'comment_notes_after' => '',
);
?>
<div id="comments">
    <ul class="comment-menu">
        <li>コメント</li>
    </ul>
    <div class="tab-content">
        <div id="comment_default" class="tab-pane fade in active">
            <?php if (have_comments()) : ?>

                <ul class="commentlist clearfix">
                    <?php wp_list_comments('type=comment&callback=custom_form_comment'); ?>
                </ul>				
            <?php endif; ?>
            <?php comment_form($comment_args); ?>
        </div>

    </div><!--End .tab-content-->
</div><!--End #comment_tabs-->
