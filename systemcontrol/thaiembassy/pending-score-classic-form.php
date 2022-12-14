<div class="scoreform">
  <div class="formLogo"><img src="./images/score/logo.png" /></div>
  <h3>คู่มือการตรวจร้านอาหารไทยเพื่อมอบตราสัญลักษณ์ Thai SELECT</h3>
  <div class="type">ประเภท <span class="type03">Classic</span></div>
  <br /><br />
  <div class="form-group">
    <label class="col-md-2 control-label">ชื่อร้าน</label>
    <div class="col-md-10">
      <div class="bs-component frmalert">
        <input type="text" readonly name="RestaurantName" class="form-control reqs" value="<?php echo $Subject?>" placeholder="กรอกข้อมูลชื่อร้าน">
      </div>
    </div>
  </div>
  <div class="info"><span class="b">ส่วนที่ 1</span> : ข้อมูลเบื้องต้น</div>
  <div class="form-group">
    <label class="col-md-2 control-label">สถานที่ตั้ง</label>
    <div class="col-md-10">
      <div class="bs-component frmalert">
        <input type="text" name="Address" class="form-control reqs" value="<?php echo $Address?>" placeholder="กรอกข้อมูลสถานที่ตั้ง">
      </div>
    </div>
  </div>
  <div class="form-group">
    <label class="col-md-2 control-label">เวลาเปิด-ปิด</label>
    <div class="col-md-10">
      <div class="bs-component frmalert">
        <input type="text" name="OpenClose" class="form-control reqs" value="<?php echo $OpenClose?>" placeholder="กรอกข้อมูลเวลาเปิด-ปิด">
      </div>
    </div>
  </div>
  <div class="form-group">
    <label class="col-md-2 control-label">สคต.</label>
    <div class="col-md-4">
      <div class="bs-component frmalert">
        <input type="hidden" name="CityID" value="<?php echo $StaffInfo->CityID?>">
        <input type="text" name="CityName" readonly class="form-control reqs" value="<?php echo $StaffInfo->CityName?>" placeholder="กรอกข้อมูลสคต.">
      </div>
    </div>
    <label class="col-md-2 control-label">ประเทศ</label>
    <div class="col-md-4">
      <div class="bs-component frmalert">
        <input type="hidden" name="CountryID" value="<?php echo $StaffInfo->CountryID?>">
        <input type="text" name="Country" readonly class="form-control reqs" value="<?php echo $StaffInfo->Country?>" placeholder="กรอกข้อมูลประเทศ">
      </div>
    </div>
  </div>
  <div class="form-group">
    <label class="col-md-2 control-label">ชื่อผู้ตรวจสอบ</label>
    <div class="col-md-10">
      <div class="bs-component frmalert">
        <input type="text" name="Fullname" readonly class="form-control reqs" value="<?php echo $StaffInfo->fullname?>" placeholder="กรอกข้อมูลชื่อผู้ตรวจสอบ">
      </div>
    </div>
  </div>
  <div class="form-group">
    <label class="col-md-2 control-label">ตำแหน่ง</label>
    <div class="col-md-10">
      <div class="bs-component frmalert">
        <input type="text" name="Position" class="form-control reqs" value="<?php echo $StaffInfo->position?>" placeholder="กรอกข้อมูลตำแหน่ง">
      </div>
    </div>
  </div>
  <div class="info"><span class="b">ส่วนที่ 2</span> : ตารางคะแนนสำหรับหลักเกณฑ์เกี่ยวกับอาหาร</div>
  <div class="subinfo">ใส่ตัวเลขคะแนนลงในช่องคะแนน พร้อมระบุเหตุผลหลังการตรวจสอบ ลงในช่องเหตุผล</div>
  <table>
    <thead>
      <tr>
        <td rowspan="2">หลักเกณฑ์</td>
        <td rowspan="2">การพิจารณา</td>
        <td colspan="2">คะแนน</td>
        <td rowspan="2">เหตุผล</td>
      </tr>
      <tr>
        <td>เต็ม</td>
        <td>ได้รับ</td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="NoDetail">1. วัตถุดิบ (20 คะแนน)</td>
        <td>1. ใช้วัตถุดิบ ส่วนผสม และเครื่องปรุงจากประเทศไทย เป็นส่วนประกอบหลัก</td>
        <td class="FullScore"><input type="text" readonly class="form-control text-center" name="Section2No1_1Score_Max" value="<?php echo $InDataMaxScore["Section2No1_1Score"]?>"></td>
        <td class="Score"><input type="text" maxlength="2" name="Section2No1_1Score" class="form-control text-center inputnumber reqs" value="" placeholder=""></td>
        <td class="Remark"><input type="text" name="Section2No1_1Remark" class="form-control " value="" placeholder=""></td>
      </tr>
      <tr>
        <td class="NoDetail"></td>
        <td>2. ใช้ข้าวจากประเทศไทยเป็นหลัก</td>
        <td class="FullScore"><input type="text" readonly class="form-control text-center" name="Section2No1_2Score_Max" value="<?php echo $InDataMaxScore["Section2No1_2Score"]?>"></td>
        <td class="Score"><input type="text" maxlength="2" name="Section2No1_2Score" class="form-control text-center inputnumber reqs" value="" placeholder=""></td>
        <td class="Remark"><input type="text" name="Section2No1_2Remark" class="form-control " value="" placeholder=""></td>
      </tr>
      <tr>
        <td colspan="5">
          <p><span class="underline">คำอธิบาย :</span></p>
          <ol>
            <li>ใช้ส่วนผสมและเครื่องปรุงถูกต้อง โดยตรวจสอบจากวัตถุดิบที่ผู้สมัครให้รายละเอียดไว้ในใบสมัคร เปรียบเทียบ ตามแนวทางพิจารณา ในส่วนที่ 4</li>
            <li>
              <div>ใช้วัตถุดิบหรือเครื่องปรุงอาหารจากประเทศไทย เป็นส่วนประกอบหลัก ตัวอย่างเช่น</div>
              <div>กรณีร้านอาหารที่หาวัตถุดิบและข้าวของไทยได้สะดวก ควรใช้วัตถุดิบของไทยมากกว่าร้อยละ 75 ของวัตถุดิบทั้งหมด</div>
              <ul>
                <li>ร้านอาหารใช้วัตถุดิบและข้าวของไทย มากกว่าร้อยละ 75 ได้ 16 - 20 คะแนน</li>
                <li>ร้านอาหารใช้วัตถุดิบและข้าวของไทย น้อยกว่าร้อยละ 75 ได้ 12 - 15 คะแนน</li>
                <li>ร้านอาหารไม่ใช้วัตถุดิบและข้าวของไทย ได้ 0 คะแนน</li>
              </ul>
              <div>กรณีร้านอาหารที่หาวัตถุดิบและข้าวของไทยได้ยาก ควรใช้วัตถุดิบของไทยไม่น้อยกว่าร้อยละ 40 ของทั้งหมด</div>
              <ul>
                <li>ร้านอาหารใช้วัตถุดิบและข้าวของไทย มากกว่าร้อยละ 40 ได้ 16 - 20 คะแนน</li>
                <li>ร้านอาหารใช้วัตถุดิบและข้าวของไทย น้อยกว่าร้อยละ 40 ถึงร้อยละ 20 ได้ 12 - 15 คะแนน</li>
                <li>ร้านอาหารไม่ใช้วัตถุดิบและข้าวของไทย ได้ 0 คะแนน</li>
              </ul>
            </li>
          </ol>
        </td>
      </tr>
      <tr>
        <td class="NoDetail">2. รสชาติอาหาร</td>
        <td>ให้ความสำคัญกับรสชาติอาหารไทย ที่มีเอกลักษณ์ความเป็นไทย ตามแนวทางการพิจารณา ในส่วนที่ 4</td>
        <td class="FullScore"><input type="text" readonly class="form-control text-center" name="Section2No2_1Score_Max" value="<?php echo $InDataMaxScore["Section2No2_1Score"]?>"></td>
        <td class="Score"><input type="text" maxlength="2" name="Section2No2_1Score" class="form-control text-center inputnumber reqs" value="" placeholder=""></td>
        <td class="Remark"><input type="text" name="Section2No2_1Remark" class="form-control " value="" placeholder=""></td>
      </tr>
      <tr>
        <td colspan="5">
          <p><span class="underline">คำอธิบาย :</span> รสชาติอาหารต้องมีความเป็นเอกลักษณ์ไทย แต่อาจจะไม่เผ็ดมาก</p>
        </td>
      </tr>
      <tr>
        <td class="NoDetail">3. สุขอนามัย  (Food Safety)</td>
        <td>ผ่านเกณฑ์มาตรฐานทางสาธารณสุขของท้องถิ่น ที่ร้านอาหารได้รับ </td>
        <td class="FullScore"><input type="text" readonly class="form-control text-center" name="Section2No3_1Score_Max" value="<?php echo $InDataMaxScore["Section2No3_1Score"]?>"></td>
        <td class="Score"><input type="text" maxlength="2" name="Section2No3_1Score" class="form-control text-center inputnumber reqs" value="" placeholder=""></td>
        <td class="Remark"><input type="text" name="Section2No3_1Remark" class="form-control " value="" placeholder=""></td>
      </tr>
      <tr>
        <td colspan="5">
          <p><span class="underline">คำอธิบาย :</span> การปรุง/การเตรียมอาหาร ภาชนะบริเวณร้าน รวมทั้งผู้ปรุง/ผู้ให้บริการ เครื่องแต่งกายพนักงาน ต้องมีความสะอาด  ถูกสุขลักษณะ </p>
        </td>
      </tr>
      <tr>
        <td class="NoDetail">4. คุณภาพอาหาร    (10 คะแนน)</td>
        <td>1. วัตถุดิบที่นำมาทำอาหาร มีความสด/สะอาด</td>
        <td class="FullScore"><input type="text" readonly class="form-control text-center" name="Section2No4_1Score_Max" value="<?php echo $InDataMaxScore["Section2No4_1Score"]?>"></td>
        <td class="Score"><input type="text" maxlength="2" name="Section2No4_1Score" class="form-control text-center inputnumber reqs" value="" placeholder=""></td>
        <td class="Remark"><input type="text" name="Section2No4_1Remark" class="form-control " value="" placeholder=""></td>
      </tr>
      <tr>
        <td class="NoDetail"></td>
        <td>
          <div>2.  ใช้วัตถุดิบถูกต้อง</div>
          <div>รายการอาหารที่รับประทาน ได้แก่</div>
          <ol class="subinput">
            <li><input type="text" name="Section2No4_2Detail[]" class="form-control " value="" placeholder=""></li>
            <li><input type="text" name="Section2No4_2Detail[]" class="form-control " value="" placeholder=""></li>
            <li><input type="text" name="Section2No4_2Detail[]" class="form-control " value="" placeholder=""></li>
            <li><input type="text" name="Section2No4_2Detail[]" class="form-control " value="" placeholder=""></li>
            <li><input type="text" name="Section2No4_2Detail[]" class="form-control " value="" placeholder=""></li>
          </ol>
        </td>
        <td class="FullScore"><input type="text" readonly class="form-control text-center" name="Section2No4_2Score_Max" value="<?php echo $InDataMaxScore["Section2No4_2Score"]?>"></td>
        <td class="Score"><input type="text" maxlength="2" name="Section2No4_2Score" class="form-control text-center inputnumber reqs" value="" placeholder=""></td>
        <td class="Remark"><input type="text" name="Section2No4_2Remark" class="form-control " value="" placeholder=""></td>
      </tr>
      <tr>
        <td colspan="5">
          <p><span class="underline">คำอธิบาย :</span> วัตถุดิบที่ใช้ต้องมีความสด สะอาด และถูกต้อง โดยดูจากแนวทางการพิจารณา ในส่วนที่ 4</p>
        </td>
      </tr>
      <tr>
        <td class="NoDetail">5. รายการอาหารไทย</td>
        <td>มีรายการอาหารไทย ไม่น้อยกว่าร้อยละ 60 ของรายการอาหารทั้งหมดที่ให้บริการ ได้แก่ อาหารจานหลัก อาหารจานเดียว อาหารว่าง ของหวาน เป็นต้น หากมีความหลากหลายของรายการอาหาร   จะได้รับการพิจารณาเป็นพิเศษ</td>
        <td class="FullScore"><input type="text" readonly class="form-control text-center" name="Section2No5_1Score_Max" value="<?php echo $InDataMaxScore["Section2No5_1Score"]?>"></td>
        <td class="Score"><input type="text" maxlength="2" name="Section2No5_1Score" class="form-control text-center inputnumber reqs" value="" placeholder=""></td>
        <td class="Remark"><input type="text" name="Section2No5_1Remark" class="form-control " value="" placeholder=""></td>
      </tr>
      <tr>
        <td colspan="5">
          <p><span class="underline">คำอธิบาย :</span> ให้คะแนนตามสัดส่วน ดังนี้</p>
          <ul>
            <li>รายการอาหารไทย ร้อยละ 95 - 100 ได้รับ  5 คะแนน</li>
            <li>รายการอาหารไทย ร้อยละ 75 - 90   ได้รับ  4 คะแนน</li>
            <li>รายการอาหารไทย ร้อยละ 60 - 74   ได้รับ  3 คะแนน</li>
          </ul>
        </td>
      </tr>
      <tr>
        <td class="NoDetail">6. การนำเสนอ    อาหาร   (10 คะแนน)</td>
        <td>1. เครื่องเคียง หรือส่วนประกอบที่ใช้ในการตกแต่งจานอาหาร มีความเหมาะสม สามารถทานได้  ที่ร้านอาหารได้รับ </td>
        <td class="FullScore"><input type="text" readonly class="form-control text-center" name="Section2No6_1Score_Max" value="<?php echo $InDataMaxScore["Section2No6_1Score"]?>"></td>
        <td class="Score"><input type="text" maxlength="2" name="Section2No6_1Score" class="form-control text-center inputnumber reqs" value="" placeholder=""></td>
        <td class="Remark"><input type="text" name="Section2No6_1Remark" class="form-control " value="" placeholder=""></td>
      </tr>
      <tr>
        <td class="NoDetail"></td>
        <td>2. การนำเสนออาหาร มีการนำเสนอ โดยสื่อถึงความคิดสร้างสรรค์</td>
        <td class="FullScore"><input type="text" readonly class="form-control text-center" name="Section2No6_2Score_Max" value="<?php echo $InDataMaxScore["Section2No6_2Score"]?>"></td>
        <td class="Score"><input type="text" maxlength="2" name="Section2No6_2Score" class="form-control text-center inputnumber reqs" value="" placeholder=""></td>
        <td class="Remark"><input type="text" name="Section2No6_2Remark" class="form-control " value="" placeholder=""></td>
      </tr>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="2">รวมคะแนนส่วนที่ 2 (ข้อ 1 - 6)</td>
        <td class="FullScore">75</td>
        <td class="Score"><input type="text" maxlength="3" readonly name="Section2Total" class="form-control text-center" value=""></td>
        <td></td>
      </tr>
    </tfoot>
  </table>
  <div class="info"><span class="b">ส่วนที่ 3</span> : ตารางคะแนนสำหรับหลักเกณฑ์เกี่ยวกับการบริการ</div>
  <table>
    <thead>
      <tr>
        <td rowspan="2">หลักเกณฑ์</td>
        <td rowspan="2">การพิจารณา</td>
        <td colspan="2">คะแนน</td>
        <td rowspan="2">เหตุผล</td>
      </tr>
      <tr>
        <td>เต็ม</td>
        <td>ได้รับ</td>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td class="NoDetail">7. พ่อครัว/แม่ครัว     (5 คะแนน)</td>
        <td>1. พ่อครัว/แม่ครัว มีความรู้ในการปรุงอาหารไทย และปรุงอาหารตามคำสั่งได้อย่างถูกต้อง รวดเร็ว มีการสัมผัสอาหารอย่างถูกวิธี</td>
        <td class="FullScore"><input type="text" readonly class="form-control text-center" name="Section3No7_1Score_Max" value="<?php echo $InDataMaxScore["Section3No7_1Score"]?>"></td>
        <td class="Score"><input type="text" maxlength="2" name="Section3No7_1Score" class="form-control text-center inputnumber reqs" value="" placeholder=""></td>
        <td class="Remark"><input type="text" name="Section3No7_1Remark" class="form-control " value="" placeholder=""></td>
      </tr>
      <tr>
        <td class="NoDetail"></td>
        <td>2. การแต่งกายถูกสุขลักษณะ สะอาด    มีการเก็บผมโดยใช้หมวกคลุมผม หรือรวบผมไว้</td>
        <td class="FullScore"><input type="text" readonly class="form-control text-center" name="Section3No7_2Score_Max" value="<?php echo $InDataMaxScore["Section3No7_2Score"]?>"></td>
        <td class="Score"><input type="text" maxlength="2" name="Section3No7_2Score" class="form-control text-center inputnumber reqs" value="" placeholder=""></td>
        <td class="Remark"><input type="text" name="Section3No7_2Remark" class="form-control " value="" placeholder=""></td>
      </tr>
      <tr>
        <td colspan="5">
          <p><span class="underline">คำอธิบาย :</span> หลังจากได้ทานอาหารแล้ว แจ้งให้ทางร้านอาหารไทยทราบว่าร้านมีคุณสมบัติเบื้องต้นเหมาะสมที่จะได้รับตรา Thai SELECT แล้วจึงขอสัมภาษณ์พ่อครัว/แม่ครัว โดยพิจารณาจากการสอบถาม/สัมภาษณ์</p>
        </td>
      </tr>
      <tr>
        <td class="NoDetail">8. การตกแต่งร้าน     (10 คะแนน)</td>
        <td>1. การตกแต่งร้านที่สร้างจุดเด่น มีเอกลักษณ์ให้จดจำ ให้ความรู้สึกสบาย และดึงดูดใจลูกค้าให้มาใช้บริการ</td>
        <td class="FullScore"><input type="text" readonly class="form-control text-center" name="Section3No8_1Score_Max" value="<?php echo $InDataMaxScore["Section3No8_1Score"]?>"></td>
        <td class="Score"><input type="text" maxlength="2" name="Section3No8_1Score" class="form-control text-center inputnumber reqs" value="" placeholder=""></td>
        <td class="Remark"><input type="text" name="Section3No8_1Remark" class="form-control " value="" placeholder=""></td>
      </tr>
      <tr>
        <td class="NoDetail"></td>
        <td>2. การจัดพื้นที่ภายในร้านเป็นสัดส่วน   ไม่อึดอัด มีช่องทางเดินเหมาะสม  </td>
        <td class="FullScore"><input type="text" readonly class="form-control text-center" name="Section3No8_2Score_Max" value="<?php echo $InDataMaxScore["Section3No8_2Score"]?>"></td>
        <td class="Score"><input type="text" maxlength="2" name="Section3No8_2Score" class="form-control text-center inputnumber reqs" value="" placeholder=""></td>
        <td class="Remark"><input type="text" name="Section3No8_2Remark" class="form-control " value="" placeholder=""></td>
      </tr>
      <tr>
        <td colspan="5">
          <p><span class="underline">คำอธิบาย :</span> ร้านที่มีพื้นที่ขนาดไม่ใหญ่มาก มีการตกแต่งร้านที่สร้างจุดเด่น มีความลงตัว ไม่อึดอัด เหมาะสมกับขนาดของพื้นที่</p>
        </td>
      </tr>
      <tr>
        <td class="NoDetail">9. คุณภาพด้านการบริการ    (10 คะแนน)</td>
        <td>1. พนักงานเสริฟ (ถ้ามี)  สามารถ       รับรายการอาหารที่สั่งได้อย่างถูกต้อง ครบถ้วน</td>
        <td class="FullScore"><input type="text" readonly class="form-control text-center" name="Section3No9_1Score_Max" value="<?php echo $InDataMaxScore["Section3No9_1Score"]?>"></td>
        <td class="Score"><input type="text" maxlength="2" name="Section3No9_1Score" class="form-control text-center inputnumber reqs" value="" placeholder=""></td>
        <td class="Remark"><input type="text" name="Section3No9_1Remark" class="form-control " value="" placeholder=""></td>
      </tr>
      <tr>
        <td class="NoDetail"> </td>
        <td>2. พนักงานมีอัธยาศัยดี มีความใส่ใจลูกค้า และมีจิตบริการ</td>
        <td class="FullScore"><input type="text" readonly class="form-control text-center" name="Section3No9_2Score_Max" value="<?php echo $InDataMaxScore["Section3No9_2Score"]?>"></td>
        <td class="Score"><input type="text" maxlength="2" name="Section3No9_2Score" class="form-control text-center inputnumber reqs" value="" placeholder=""></td>
        <td class="Remark"><input type="text" name="Section3No9_2Remark" class="form-control " value="" placeholder=""></td>
      </tr>
      <tr>
        <td colspan="5">
          <p><span class="underline">คำอธิบาย :</span> พนักงานมีความใส่ใจ หรือมีจิตบริการแก่ลูกค้า</p>
        </td>
      </tr>
    </tbody>
    <tfoot>
      <tr>
        <td colspan="2">รวมคะแนนส่วนที่ 3 (ข้อ 7 - 9)</td>
        <td class="FullScore">25</td>
        <td class="Score"><input type="text" maxlength="3" readonly name="Section3Total" class="form-control text-center" value=""></td>
        <td></td>
      </tr>
      <tr>
        <td colspan="2">รวมคะแนนส่วนที่ 2 และ 3 (ข้อ 1 - 9)</td>
        <td class="FullScore">100</td>
        <td class="Score"><input type="text" maxlength="3" readonly name="SectionTotalAll" class="form-control text-center" value=""></td>
        <td></td>
      </tr>
    </tfoot>
  </table>

  <div class="form-group mt20">
    <label class="col-md-2 control-label"> </label>
    <div class="col-md-10">
      <div class="bs-component">
        <div class="radio-custom mb10">
          <input type="radio" id="radioPassTheCriteria_ClassicP" name="PassTheCriteria" value="P">
          <label for="radioPassTheCriteria_ClassicP">ผ่านเกณฑ์ และได้คะแนนตั้งแต่ 75 - 89 คะแนนขึ้นไป ได้รับตรา <span class="ColorClassic">Thai SELECT Classic</span> </label>
        </div>
        <div class="radio-custom mb10">
          <input type="radio" id="checkboxPassTheCriteria_F" name="PassTheCriteria" value="F">
          <label for="checkboxPassTheCriteria_F">ไม่ผ่านเกณฑ์</label>
        </div>
      </div>
    </div>
  </div>
  <div class="form-group">
    <label class="col-md-2 control-label">ผู้ตรวจสอบ</label>
    <div class="col-md-4">
      <div class="bs-component">
        <input type="hidden" name="InspectionID" class="form-control" value="<?php echo $StaffInfo->id?>" placeholder="">
        <input type="text" readonly name="InspectionName" class="form-control" value="<?php echo $StaffInfo->fullname?>" placeholder="">
      </div>
    </div>
    <label class="col-md-2 control-label">วันที่ตรวจสอบ</label>
    <div class="col-md-4">
      <div class="bs-component">
        <label for="datepickerFrom" class="field prepend-icon">
            <input type="text" id="InspectionDate" name="InspectionDate" readonly="readonly" class="form-control date" value="<?php echo date("d/m/Y")?>" placeholder="11/11/1111">
            <label class="field-icon"><i class="fa fa-calendar-o"></i></label>
        </label>
      </div>
    </div>
  </div>

</div>
