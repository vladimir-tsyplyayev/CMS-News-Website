<?
// СТРАНИЦА ВСТУПИТЬ В ПАРТИЮ

print('
<td style="padding:0 0 0 0;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td style="padding:29 0 5 35; background-repeat:no-repeat; background-position:bottom left;" background="images/title_long.png"><a class="title" style="line-height:normal;">ВСТУПЛЕНИЕ В ПАРТИЮ</a></td>
          </tr>
        </table>

       <table style="padding:2 30 0 50; line-height:normal;">

          <tr>
            <td valign=top><br>
              <div class="otstup">Членом Партии регионов может быть гражданин
                Украины, который признает Устав и Программу Партии, принимает
                участие в работе одной из организационных структур Партии, соответственно
                Конституции Украины имеет право голоса на выборах.
                <p>Членство в Партии регионов несовместимо с одновременным пребыванием
                  в других политических партиях. </p>
                <p>Если Вы приняли решение стать членом Партии регионов, для этого
                  необходимо: <br>
                  1. Ознакомиться с <a href="?nav=ustav" class="link">Уставом</a> и <a href="?nav=program" class="link">Программой Партии</a>. <br>

                  2. Заполнить Заявление о вступлении в Партию регионов и вместе
                  с фотокарточкой (размером 3х4 см) передать в региональное отделение
                  Партии, либо заполнить электронную анкету, расположенную ниже,
                  после чего с Вами свяжутся представители регионального отделения</p>
                <p>Прием в Партию регионов осуществляется по решению собрания
                  первичных, сельских, поселковых организаций Партии, по решению
                  высших или исполнительных руководящих органов Партии регионов
                  и парторганизаций.</p>
                Членство в Партии регионов удостоверяется партийным билетом.
              </div>
    <form name="form1" method="post" action="anketa_send.php">
                <p><b>Персональные данные :</b><br>
                </p>
                <p>Фамилия: *<br>

                  <INPUT TYPE="TEXT" SIZE="30" NAME="surname">
                  <br>
                  Имя: *<br>
                  <INPUT TYPE="TEXT" SIZE="30" NAME="name">
                  <br>
                  Отчество: * <br>
                  <INPUT TYPE="TEXT" SIZE="30" NAME="patronymic">
                  <br>

                  <br>
                  Дата рождения: *<br>
                  <br>
                  Число:
                  <INPUT TYPE="TEXT" MAXLENGTH="2" SIZE="2" NAME="day">
                  &nbsp;&nbsp;Месяц:
                  <input type="TEXT" size="10" name="month">
                  &nbsp;&nbsp;Год:
                  <INPUT TYPE="TEXT" MAXLENGTH="4" SIZE="4" NAME="year">
                </p>

                <p>Образование:<br>
                  <TEXTAREA ROWS="5" NAME="education"></TEXTAREA>
                  <br>
                  <br>
                  Квалификация по образованию:<br>
                  <INPUT TYPE="TEXT" SIZE="30" NAME="qualification">
                  <br>
                  <br>
                  Ученая степень, ученое звание:<br>
                  <INPUT TYPE="TEXT" SIZE="30" NAME="science">
                  <br>
                  <br>
                  <b>Место проживания (адрес):</b><br>
                  <br>
                  <INPUT TYPE="TEXT" SIZE="30" NAME="address">
                </p>

                <p>Телефон дом.(моб.): *<br>
                  <INPUT TYPE="TEXT" SIZE="30" NAME="home_phone">
                  <br>
                  Телефон служебный: *<br>
                  <INPUT TYPE="TEXT" SIZE="30" NAME="work_phone">
                  <br>
                  E-mal: <br>
                  <input type="TEXT" name="mail">
                  <br><br>
                  Место работы, должность:<br>
                  <TEXTAREA ROWS="2" NAME="ocupation"></TEXTAREA>
                  <br>
                  <br>
                  Участие в избирательных органах:<br>
                  <TEXTAREA ROWS="2" NAME="election"></TEXTAREA>
                  <br>
                  <br>
                  Награды, почетные звания:<br>
                  <TEXTAREA ROWS="2" NAME="election"></TEXTAREA>
                  <br>
                  <br>

                  <b>Паспорт:</b><br>
                  <br>
                  Серия: *
                  <INPUT TYPE="TEXT" NAME="series">
                  Номер: *
                  <INPUT TYPE="TEXT" NAME="number">
                </p>
                <p>Кем выдан: *<br>
                  <TEXTAREA ROWS="3" NAME="whom_given"></TEXTAREA>
                </p>

                <p>Когда выдан: * <br>
                  <INPUT TYPE="TEXT" SIZE="30" NAME="when_given">
                  <br>
                  <br>
                  <b>Дополнительная информация:</b><br>
                  <TEXTAREA ROWS="6" NAME="additional_information"></TEXTAREA>
                  <br><br>
                  <input type="checkbox" onClick="if(this.checked){document.getElementById(\'send\').disabled=false;}else{document.getElementById(\'send\').disabled=true;}"/>Отправляя эту информацию вы соглашаетесь с нижеследующим.<br><br>
                  <b>Прошу прийняти мене в члени Партії реонів. Статут та Програму партії визнаю і підтримую. Зобов\'язуюсь брати участь у роботі партійних організацій, виконувати пртійні рішення.
                  Підтверджую, що не є членом іншої політичної партії.</b>
                  <br><br>
                  Поля, отмеченные (*), обязательны к заполнению <br>
                  <br>

                  <INPUT TYPE="submit" id="send" VALUE="Отправить анкету" METHOD="post" disabled />
                </p>
      </form>
            </td>
          </tr>

        </table>





        </td>
');

?>