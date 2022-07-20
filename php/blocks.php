<?php
function pasteBlock_gender($id)
{
    ?>
    <div class="reg__check-item">
        <div class="reg__check-title title">М/Ж:</div>
        <div class="reg__gender">
            <input type="radio" name="gender-id<?= $id ?>" class="check__default_male" id="check-gender1-id<?= $id ?>"
                   checked>
            <label class="check" for="check-gender1-id<?= $id ?>"></label>

            <input type="radio" name="gender-id<?= $id ?>" class="check__default_female"
                   id="check-gender2-id<?= $id ?>">
            <label class="check" for="check-gender2-id<?= $id ?>"></label>
        </div>
    </div>
<!--    <div class="reg__check-item">-->
<!--        <div class="reg__check-title title">М/Ж:</div>-->
<!--        <div class="reg__gender">-->
<!--            <input type="radio" name="gender-id--><?//= $id ?><!--" class="check__default_male" id="check-gender1-id--><?//= $id ?><!--"-->
<!--                   checked>-->
<!--            <label class="check" for="check-gender1-id--><?//= $id ?><!--"></label>-->
<!---->
<!--            <input type="radio" name="gender-id--><?//= $id ?><!--" class="check__default_female"-->
<!--                   id="check-gender2-id--><?//= $id ?><!--">-->
<!--            <label class="check" for="check-gender2-id--><?//= $id ?><!--"></label>-->
<!--        </div>-->
<!--    </div>-->
    <?php
}

function pasteBlock_datesOfStay($id)
{
    ?>
    <div class="reg__check-item">
        <div class="reg__check-title title">Дни:</div>
        <div class="reg__date-of-stay">
            <input type="checkbox" name="check-date1-id<?= $id ?>" class="check__default" id="check-one-id<?= $id ?>"
                   value="1" checked>
            <label class="check" for="check-one-id<?= $id ?>">18</label>

            <input type="checkbox" name="check-date2-id<?= $id ?>" class="check__default" id="check-two-id<?= $id ?>"
                   value="1" checked>
            <label class="check" for="check-two-id<?= $id ?>">19</label>

            <input type="checkbox" name="check-date3-id<?= $id ?>" class="check__default" id="check-three-id<?= $id ?>"
                   value="1" checked>
            <label class="check" for="check-three-id<?= $id ?>">20</label>

            <input type="checkbox" name="check-date4-id<?= $id ?>" class="check__default" id="check-four-id<?= $id ?>"
                   value="1" checked>
            <label class="check" for="check-four-id<?= $id ?>">21</label>
        </div>
    </div>
    <?php
}

function pasteBlock_phone($id)
{
    ?>
    <div id="phone-id<?= $id ?>">
        <div class="reg-title">Телефон №<?= $id ?></div>
        <div class="phone-input" id="phone-input-id<?= $id ?>">
            <input class="reg-txt" type="text" value=""
                   onchange="phoneOnBlur(this); ajaxChange('PHONE','CHANGE','','phone',this.value)"
                   name="phone-id<?= $id ?>" placeholder="Номер телефона">
            <input class="reg-txt" type="hidden" value="" name="phone-id<?= $id ?>"
                   placeholder="PHONE ID (ИЛЬЯ ЭТО НАДО СКРЫТЬ)">
            <input type="button" onclick="phoneCall('phone-id<?= $id ?>')"
                   id="call-id<?= $id ?>" value=""
                   class="phone-input__call title">
        </div>
        <div class="input-wrap" id="input-wrap-phone-id<?= $id ?>">
            <input class="reg-txt" type="text" value="" onchange="ajaxChange('PHONE','CHANGE',,'note',this.value)"
                   name="phone-note-id<?= $id ?>" placeholder="Комментарий к телефону">
            <input type="button"
                   onclick="ajaxChange('PHONE','DELETE',); delPhone(this)"
                   id="1" value="X" class="delete-btn">
        </div>
    </div>

    <?php
}

?>