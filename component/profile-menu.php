<div class="webboard-menu">
  <div class="login-block">
    <div class="avatar">
      <label for="upload-avatar">
        <img id="avatar-img" src="public/assets/app/images/icon/user.svg" alt="">
      </label>
      <input type="file" name="avatar" id="upload-avatar" />
    </div>
    <div class="info">
      <p>
        <span class="font-02 color-white fw-700">หลักทรัพย์ ฉัฐธนิน</span>
      </p>
      <p class="xs">
        <span class="font-02 color-white fw-400">
          hoonn.8080@gmail.com
        </span>
      </p>
    </div>
  </div>
  <div class="menus">
    <ul>
      <li class="<?php echo $activeMenu === 'edit-profile' ? 'active' : '' ?>">
        <div class="menu-item">
          <div class="icon mr-2">
            <svg width="22" height="22" viewBox="0 0 22 22" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M9.9999 0.401367C6.6063 0.401367 5.1999 2.57817 5.1999 5.20137C5.1999 6.08457 5.62178 6.97168 5.62178 6.97168C5.45218 7.06928 5.17325 7.37909 5.24365 7.92949C5.37485 8.95589 5.81983 9.21727 6.10303 9.23887C6.21103 10.1965 7.2399 11.4214 7.5999 11.5998V13.1998C6.7999 15.5998 0.399902 13.9998 0.399902 19.5998H11.1624L11.2015 19.367C11.2551 19.0342 11.4115 18.7273 11.6499 18.4889L15.264 14.8732C13.9264 14.4788 12.7183 14.1558 12.3999 13.1998V11.5998C12.7599 11.4214 13.7888 10.1965 13.8968 9.23887C14.18 9.21727 14.625 8.95589 14.7562 7.92949C14.8266 7.37829 14.5476 7.06928 14.378 6.97168C14.378 6.97168 14.7999 6.17017 14.7999 5.20137C14.7999 3.25897 14.0375 1.60137 12.3999 1.60137C12.3999 1.60137 11.8311 0.401367 9.9999 0.401367ZM20.5858 12.3998C20.2238 12.3998 19.8618 12.5379 19.5858 12.8139L19.1655 13.2342L21.1655 15.2342L21.5858 14.8139C22.1378 14.2619 22.1378 13.3659 21.5858 12.8139C21.3098 12.5379 20.9478 12.3998 20.5858 12.3998ZM18.0343 14.3654L12.7812 19.6201L12.3999 21.9998L14.7812 21.6201L20.0343 16.3654L18.0343 14.3654Z" fill="white" />
            </svg>

          </div>
          <div class="label">
            <p>
              <span class="font-02 fw-700">แก้ไขโปรไฟล์</span>
            </p>
          </div>
        </div>
      </li>
      <li class="<?php echo $activeMenu === 'my-posts' ? 'active' : '' ?>">
        <div class="menu-item">
          <div class="icon mr-2">
            <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M16.2 0.200012H1.79995C0.915951 0.200012 0.199951 0.916012 0.199951 1.80001V16.2C0.199951 17.084 0.915951 17.8 1.79995 17.8H16.2C17.084 17.8 17.7999 17.084 17.7999 16.2V1.80001C17.7999 0.916012 17.084 0.200012 16.2 0.200012ZM10.6 13H4.19995C3.75835 13 3.39995 12.6416 3.39995 12.2C3.39995 11.7584 3.75835 11.4 4.19995 11.4H10.6C11.0416 11.4 11.4 11.7584 11.4 12.2C11.4 12.6416 11.0416 13 10.6 13ZM13.8 9.80001H4.19995C3.75835 9.80001 3.39995 9.44161 3.39995 9.00001C3.39995 8.55841 3.75835 8.20001 4.19995 8.20001H13.8C14.2416 8.20001 14.6 8.55841 14.6 9.00001C14.6 9.44161 14.2416 9.80001 13.8 9.80001ZM13.8 6.60001H4.19995C3.75835 6.60001 3.39995 6.24161 3.39995 5.80001C3.39995 5.35841 3.75835 5.00001 4.19995 5.00001H13.8C14.2416 5.00001 14.6 5.35841 14.6 5.80001C14.6 6.24161 14.2416 6.60001 13.8 6.60001Z" fill="white" />
            </svg>
          </div>
          <div class="label">
            <p>
              <span class="font-02 fw-700">กระทู้ของฉัน</span>
            </p>
          </div>
        </div>
      </li>
      <li class="<?php echo $activeMenu === 'my-complaint' ? 'active' : '' ?>">
        <div class="menu-item">
          <div class="icon mr-2">
            <svg width="22" height="21" viewBox="0 0 22 21" fill="none" xmlns="http://www.w3.org/2000/svg">
              <path d="M11.0001 0.400024C5.2561 0.400024 0.600098 4.34002 0.600098 9.20002C0.600098 11.8944 2.03476 14.3028 4.28916 15.9172C4.34672 17.146 4.15632 18.8427 2.46104 19.625C2.45999 19.6255 2.45895 19.6261 2.45791 19.6266C2.38217 19.6554 2.31696 19.7065 2.27092 19.7732C2.22488 19.8399 2.20019 19.919 2.2001 20C2.2001 20.1061 2.24224 20.2079 2.31725 20.2829C2.39227 20.3579 2.49401 20.4 2.6001 20.4C2.61157 20.4 2.62304 20.3995 2.63447 20.3985C4.58169 20.386 6.23472 19.3337 7.3751 18.2219C7.7367 17.8691 8.2408 17.6955 8.7376 17.7891C9.4656 17.9275 10.2225 18 11.0001 18C16.7441 18 21.4001 14.06 21.4001 9.20002C21.4001 4.34002 16.7441 0.400024 11.0001 0.400024ZM11.0001 3.60002C12.7649 3.60002 14.2001 5.03522 14.2001 6.80002C14.2001 8.17202 13.3436 8.96322 12.6548 9.60002C12.1252 10.0888 11.8001 10.4096 11.8001 10.8H10.2001C10.2001 9.68882 10.9592 8.98746 11.5688 8.42346C12.208 7.83306 12.6001 7.43922 12.6001 6.80002C12.6001 5.91762 11.8825 5.20002 11.0001 5.20002C10.1177 5.20002 9.4001 5.91762 9.4001 6.80002H7.8001C7.8001 5.03522 9.2353 3.60002 11.0001 3.60002ZM11.0001 12.8C11.6625 12.8 12.2001 13.3376 12.2001 14C12.2001 14.6624 11.6625 15.2 11.0001 15.2C10.3377 15.2 9.8001 14.6624 9.8001 14C9.8001 13.3376 10.3377 12.8 11.0001 12.8Z" fill="#4B2321" />
            </svg>
          </div>
          <div class="label">
            <p>
              <span class="font-02 fw-700">เรื่องร้องเรียนของฉัน</span>
            </p>
          </div>
        </div>
      </li>
    </ul>
  </div>
</div>