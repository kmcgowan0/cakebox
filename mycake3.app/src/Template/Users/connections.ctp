<?php if ($user->upload) :
    $profile_img = $user->upload;
else :
    $profile_img = 'placeholder.png';
endif; ?>
    <div class="main-user" style="background-image: url(/img/<?php echo $profile_img; ?>)"></div>


<?php if ($distinct_users->count()) : ?>
    <div class="related view large-9 medium-8 columns content">
        <h4><?= __('Related Users') ?></h4>
        <?php foreach ($distinct_users as $related_user):
            if ($related_user->id != $user->id) : ?>

                <?php
                $related_interests = [];

                foreach ($user_matching_data as $matching_datum) {
                    if ($matching_datum['UsersInterests']->user_id == $related_user->id) {
                        array_push($related_interests, $matching_datum['Interests']->name);
                    }
                }
                $interest_count = count($related_interests);
                ?>
<p>Interests in common with <?php echo $related_user->firstname; ?>: <?php foreach ($related_interests as $related_interest) { echo $related_interest . ', '; } ?></p>

                <?php if ($related_user->upload) :
                    $related_profile_img = $related_user->upload;
                else :
                    $related_profile_img = 'placeholder.png';
                endif; ?>
                <a href="/messages/view/<?= $related_user->id ?>">
                    <div class="related-user main-user"
                         style="border: solid #000 <?php echo $interest_count; ?>px; background-image: url(/img/<?php echo $related_profile_img; ?>)">
                        <p><?= h($related_user->firstname) ?></p>
                    </div>
                </a>
            <?php endif; ?>
        <?php endforeach; ?>

    </div>
<?php endif; ?>