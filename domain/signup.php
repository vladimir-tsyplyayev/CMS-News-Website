<?
// �������� �������� � ������

print('
<td style="padding:0 0 0 0;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td style="padding:29 0 5 35; background-repeat:no-repeat; background-position:bottom left;" background="images/title_long.png"><a class="title" style="line-height:normal;">���������� � ������</a></td>
          </tr>
        </table>

       <table style="padding:2 30 0 50; line-height:normal;">

          <tr>
            <td valign=top><br>
              <div class="otstup">������ ������ �������� ����� ���� ���������
                �������, ������� �������� ����� � ��������� ������, ���������
                ������� � ������ ����� �� ��������������� �������� ������, ��������������
                ����������� ������� ����� ����� ������ �� �������.
                <p>�������� � ������ �������� ������������ � ������������� �����������
                  � ������ ������������ �������. </p>
                <p>���� �� ������� ������� ����� ������ ������ ��������, ��� �����
                  ����������: <br>
                  1. ������������ � <a href="?nav=ustav" class="link">�������</a> � <a href="?nav=program" class="link">���������� ������</a>. <br>

                  2. ��������� ��������� � ���������� � ������ �������� � ������
                  � ������������� (�������� 3�4 ��) �������� � ������������ ���������
                  ������, ���� ��������� ����������� ������, ������������� ����,
                  ����� ���� � ���� �������� ������������� ������������� ���������</p>
                <p>����� � ������ �������� �������������� �� ������� ��������
                  ���������, ��������, ���������� ����������� ������, �� �������
                  ������ ��� �������������� ����������� ������� ������ ��������
                  � ���������������.</p>
                �������� � ������ �������� �������������� ��������� �������.
              </div>
    <form name="form1" method="post" action="anketa_send.php">
                <p><b>������������ ������ :</b><br>
                </p>
                <p>�������: *<br>

                  <INPUT TYPE="TEXT" SIZE="30" NAME="surname">
                  <br>
                  ���: *<br>
                  <INPUT TYPE="TEXT" SIZE="30" NAME="name">
                  <br>
                  ��������: * <br>
                  <INPUT TYPE="TEXT" SIZE="30" NAME="patronymic">
                  <br>

                  <br>
                  ���� ��������: *<br>
                  <br>
                  �����:
                  <INPUT TYPE="TEXT" MAXLENGTH="2" SIZE="2" NAME="day">
                  &nbsp;&nbsp;�����:
                  <input type="TEXT" size="10" name="month">
                  &nbsp;&nbsp;���:
                  <INPUT TYPE="TEXT" MAXLENGTH="4" SIZE="4" NAME="year">
                </p>

                <p>�����������:<br>
                  <TEXTAREA ROWS="5" NAME="education"></TEXTAREA>
                  <br>
                  <br>
                  ������������ �� �����������:<br>
                  <INPUT TYPE="TEXT" SIZE="30" NAME="qualification">
                  <br>
                  <br>
                  ������ �������, ������ ������:<br>
                  <INPUT TYPE="TEXT" SIZE="30" NAME="science">
                  <br>
                  <br>
                  <b>����� ���������� (�����):</b><br>
                  <br>
                  <INPUT TYPE="TEXT" SIZE="30" NAME="address">
                </p>

                <p>������� ���.(���.): *<br>
                  <INPUT TYPE="TEXT" SIZE="30" NAME="home_phone">
                  <br>
                  ������� ���������: *<br>
                  <INPUT TYPE="TEXT" SIZE="30" NAME="work_phone">
                  <br>
                  E-mal: <br>
                  <input type="TEXT" name="mail">
                  <br><br>
                  ����� ������, ���������:<br>
                  <TEXTAREA ROWS="2" NAME="ocupation"></TEXTAREA>
                  <br>
                  <br>
                  ������� � ������������� �������:<br>
                  <TEXTAREA ROWS="2" NAME="election"></TEXTAREA>
                  <br>
                  <br>
                  �������, �������� ������:<br>
                  <TEXTAREA ROWS="2" NAME="election"></TEXTAREA>
                  <br>
                  <br>

                  <b>�������:</b><br>
                  <br>
                  �����: *
                  <INPUT TYPE="TEXT" NAME="series">
                  �����: *
                  <INPUT TYPE="TEXT" NAME="number">
                </p>
                <p>��� �����: *<br>
                  <TEXTAREA ROWS="3" NAME="whom_given"></TEXTAREA>
                </p>

                <p>����� �����: * <br>
                  <INPUT TYPE="TEXT" SIZE="30" NAME="when_given">
                  <br>
                  <br>
                  <b>�������������� ����������:</b><br>
                  <TEXTAREA ROWS="6" NAME="additional_information"></TEXTAREA>
                  <br><br>
                  <input type="checkbox" onClick="if(this.checked){document.getElementById(\'send\').disabled=false;}else{document.getElementById(\'send\').disabled=true;}"/>��������� ��� ���������� �� ������������ � �������������.<br><br>
                  <b>����� �������� ���� � ����� ���� �����. ������ �� �������� ���� ������ � ��������. �����\'������ ����� ������ � ����� �������� ����������, ���������� ����� ������.
                  ϳ���������, �� �� � ������ ���� �������� ����.</b>
                  <br><br>
                  ����, ���������� (*), ����������� � ���������� <br>
                  <br>

                  <INPUT TYPE="submit" id="send" VALUE="��������� ������" METHOD="post" disabled />
                </p>
      </form>
            </td>
          </tr>

        </table>





        </td>
');

?>