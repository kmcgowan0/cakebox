
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
                $related_interest_str = array();
                foreach ($related_interests as $related_interest) {
                    $related_interest_str[] = $related_interest;
                }
                ?>
                <p>Interests in common with <?php echo $related_user->firstname; ?>
                    : <?php echo implode(", ", $related_interest_str); ?></p>

                <?php if ($related_user->upload) :
                    $related_profile_img = $related_user->upload;
                else :
                    $related_profile_img = 'placeholder.png';
                endif; ?>
                <a href="#" data-open="modal-<?php echo $related_user->id; ?>" data-id="<?php echo $related_user->id; ?>" class="reveal-link">
                    <div class="related-user main-user"
                         style="border: solid #000 <?php echo $interest_count; ?>px; background-image: url(/img/<?php echo $related_profile_img; ?>)">
                        <p><?= h($related_user->firstname) ?></p>
                    </div>
                </a>

                <div class="reveal" id="modal-<?php echo $related_user->id; ?>" data-reveal>
                    <div class="profile-small" style="background-image: url(/img/<?php echo $related_profile_img; ?>)"></div>
                    <div id="messages<?php echo $related_user->id; ?>"></div>
                    <div class="messages-in-view">
                        <?= $this->Form->create($message, ['id' => 'message-form']) ?>
                        <fieldset>
                            <?php
                            echo $this->Form->input('body', ['type' => 'text', 'label' => false, 'id' => 'body']);
                            echo $this->Form->hidden('recipient', ['value' => $related_user->id]);
                            ?>
                        </fieldset>
                        <?= $this->Form->button(__('Send')) ?>
                        <?= $this->Form->end() ?>
                    </div>
                    <h2 id="modalTitle">Awesome. I have it. <?php echo $related_user->id; ?></h2>
                    <p class="lead">Your couch.  It is mine.</p>
                    <p>I'm a cool paragraph that lives inside of an even cooler modal. Wins!</p>
                    <button class="close-button" data-close aria-label="Close modal" type="button">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>


            <?php endif;
        endforeach; ?>

    </div>
<?php endif; ?>

