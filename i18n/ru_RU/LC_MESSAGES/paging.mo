��    ;      �  O   �        �   	  >   �  �   �  �  [     	     '	  ;   6	     r	     	     �	     �	     �	     �	     �	     �	     �	     �	  �   �	     �
     �
     �
     �
     �
     �
  �   �
     �     �     �                      
   (     3     @     T     `     q          �  �   �     �     �     �     �     �     �     �  -   �  �  �    �     �     �     �  ]   �     J     R  t   V    �    �  |   �    \  �  y     7  2   H  �   {     �  F        Z  0   g     �  5   �  0   �          &     7  �  W     N!     a!     !     �!  %   �!     �!  b  �!     H#  -   Y#  !   �#  (   �#     �#     �#     �#     �#     $  '   0$     X$  9   v$  !   �$  $   �$  >   �$  �  6%     �&  
   '     '     '     /'     B'     W'  K   n'  )  �'    �-  #   �/  :   #0  :   ^0  v   �0  
   1     1  �    1     $              4   5   /      8   6          1   -          %   #              )         :         *                     (         9              '                +                  "   &   .              	            3   !      0   2             7              ;      ,          
    <strong>Force</strong><br> Send the headers telling the phone to go into auto answer mode. This may not work, and is dependant on the phone. <strong>Reject</strong><br> Return a BUSY signal to the caller <strong>Ring</strong><br> Treat the page as a normal call, and ring the extension (if Call Waiting is disabled, this will return BUSY <ul>
<li><b>"Skip"</b> will not page any busy extension. All other extensions will be paged as normal</li>
<li><b>"Force"</b> will not check if the device is in use before paging it. This means conversations can be interrupted by a page (depending on how the device handles it). This is useful for "emergency" paging groups.</li>
<li><b>"Whisper"</b> will attempt to use the ChanSpy capability on SIP channels, resulting in the page being sent to the device's earpiece "whispered" to the user but not heard by the remote party. If ChanSpy is not supported on the device or otherwise fails, no page will get through. It probably does not make too much sense to choose duplex if using Whisper mode.</li>
</ul> Actions Add Page Group Annoucement to be played to remote party. Default is a beep Applications Auto-answer defaults Beep Busy Extensions Default Default Group Inclusion Default Page Group Delete Description Device List Devices to page. Please note, paging calls the actual device (and not the user). Amount of pagable devices is restricted by the advanced setting key PAGINGMAXPARTICIPANTS and is currently set to  Disabled Drop Silence Duplex Exclude Force Group Description If you choose to make a Page Group the "default" page group, a checkbox will appear in the Extensions Module that will allow you to include or exclude that Extension in the default Page Group when editing said extension Include Intercom Override Intercom prefix List Page Groups No None Not Selected Page Group Page Group:  Page Group: %s (%s) Page Groups Paging Extension Paging Groups Paging and Intercom Paging and Intercom settings Paging is typically one way for announcements only. Checking this will make the paging duplex, allowing all phones in the paging group to be able to talk and be heard by all. This makes it like an "instant conference" Reject Reset Ring Selected Settings Skip Submit The number users will dial to page this group This module is for specific phones that are capable of Paging or Intercom. This section is for configuring group paging, intercom is configured through <strong>Feature Codes</strong>. Intercom must be enabled on a handset before it will allow incoming calls. It is possible to restrict incoming intercom calls to specific extensions only, or to allow intercom calls from all extensions but explicitly deny from specific extensions.<br /><br />This module should work with Aastra, Grandstream, Linksys/Sipura, Mitel, Polycom, SNOM , and possibly other SIP phones (not ATAs). Any phone that is always set to auto-answer should also work (such as the console extension if configured). This option drops what Asterisk detects as silence from entering into the bridge. Enabling this option will drastically improve performance and help remove the buildup of background noise from the conference. Highly recommended for large conferences due to its performance enhancements. Unknown Request User Intercom Allow User Intercom Disallow When using Intercom to page an extension, if the extension is in use, you have three options. Whisper Yes You can include or exclude this extension/device from being part of the default page group when creating or editing. Project-Id-Version: 1.3
Report-Msgid-Bugs-To: 
POT-Creation-Date: 2020-11-26 04:19+0000
PO-Revision-Date: 2016-07-14 10:46+0000
Last-Translator: Weblate Admin <admin@postmet.com>
Language-Team: Russian <https://weblate.postmet.com/projects/freepbx/paging/ru_RU/>
Language: ru_RU
MIME-Version: 1.0
Content-Type: text/plain; charset=UTF-8
Content-Transfer-Encoding: 8bit
Plural-Forms: nplurals=3; plural=n%10==1 && n%100!=11 ? 0 : n%10>=2 && n%10<=4 && (n%100<10 || n%100>=20) ? 1 : 2;
X-Generator: Weblate 2.2-dev
 <strong>Запустить</strong><br>.Послать заголовки,предписывающие телефону  перейти в режим автоответа. Это может не работать, и это зависит от модели телефона. <strong>Отбросить</strong><br>Возврат сигнала "Занято"  вызывающему абоненту <strong>Звонить</strong><br> Интерпретировать оповещение как обычный вызов, заставляя телефон звонить(если функция ОжиданиеВызова отключена,то  это вернёт ЗАНЯТО) <ul>
<li><b>"Пропустить"</b>оповещение не будет посылаться на любой занятый внутренний номер.Все остальные внутренние номера будут оповещаться как обычно</li>
<li><b>"Запустить"</b> перед оповещением проверка устройства на занятость не будет осуществляться.Это означает, что разговор может быть прерван оповещением(в зависимости от того как устройство это поддерживает).Это удобно для "экстренных" групп оповещения.</li>
<li><b>"Шёпот"</b> будет осуществляться попытка использовать возможность ChanSpy на SIP-каналах, в результате чего оповещение будет посылаться на наушник устройства "шёпотом", так,чтобы не слышали находящиеся рядом персоны. Если функция ChanSpy не поддерживается устройством,или произошла какая-либо ошибка,то оповещение не пройдёт далее. Можно выбрать режим дуплекса если используется режим Шёпота.</li>
</ul> Действия Добавить группу оповещения Приветствие , воспроизводимое удаленной стороне . По умолчанию - Сигнал Приложения Настройки по умолчанию для автоответа Сигнал Занятые внутренние номера По-умолчанию Включения в дефолтную группу Дефолтная пейджинг-группа Удалить Описание Список устройств Устройство, на которое посылается оповещение.Обратите внимание,что оповещение вызывает конкретное устройство,а не пользователя.Количество устройство,на которые можно посылать оповещения ограничено дополнительной настройкой PAGINGMAXPARTICIPANTS и на данный момент установлено в  Выключено Прервать тишину Дуплекс Исключить Форсированный режим Описание группы Если вы назначите  группу оповещения  по умолчанию, то  на странице модуля "Внутренние номера "появится  возможность включить или исключить внутренний номер на странице  оповещений по умолчанию Включить Игнорирование Интеркома Префикс интеркома Список групп страницы Нет Нет Не выбран Пейджинг-группа Пейджинг-группа:  Группа страницы : %s (%s) Группы страницы Внутренний номер для пейджинга Группы оповещения Пейджинг и интерком Настройки оповещений  и интеркома Пейджинг обычно односторонний вид связи, только для объявлений. Отметив тут, можно задействовать дуплексную связь в обе стороны, разрешая всем телефонам в пейджинговой группе говорить и слышать всех. Это выглядит как "мгновенная конференция" Отклонить Сброс Звонок Выбранно Настройки Пропускать Подтвердить Этот номер служит для звонка в эту группу Этот модуль предназначен для тех телефонов, которые имеют возможность разговора без поднятия трубки по громкой связи или интеркому. Эта секция конфигуририрует пейджинг - группу вызова по селекторной связи, сам интерком конфигурируется в секции <strong>Сервисные коды</strong>. Функция интеркома должна быть включена на телефоне прежде, чем будет задействована возможность принимать вызовы. Есть возможность ограничить приём входящих звонков на интерком только с одного конкретного внутреннего номера, или наоборот, разрешить интерком со всех номеров, кроме некоторых конкретных.<br /><br />Этот модуль хорошо работает с телефонами Aastra, Grandstream, Cisco/Linksys/Sipura, Mitel, Polycom, Snom, и, возможно, с другими SIP телефонами (не адаптерами!). Любой из этих телефонов можно установить в автоответ на интерком, который также вполне приемлем (как и консольное расширение, если оно сконфигурено). Эта опция   отбрасывает всё, что Астериск определяет как тишину . Включение этой опции существенно увеличивает производительность и помогает избавиться от  нарастания фонового шума  во время конференции. Особенно рекомендуется во время больших конференций для увеличения производительности. Неизвестный запрос Пользователь Интерком разрешён Пользователь Интерком запрещён Когда используется Интерком для оповещения  внутреннего номера. Шопот Да Можно включать или исключать этот внутренний номер/устройство из дефолтной пейджинговой группы при создании или редактировании. 