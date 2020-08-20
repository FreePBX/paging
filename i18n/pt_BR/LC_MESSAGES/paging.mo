��    L      |  e   �      p  �   q  >   �  �   =  �  �     �
     �
  Y  �
  ;   �     4     A     N     c     h     x     �     �     �     �     �  �   �     �     �     �     �     �     �     �     �     �  �   �     �     �     �     �     �          /     ?     R     d     y     �     �     �  c   �  
                  /     ;     L     a     o     �  �   �     z     �     �     �     �     �     �     �  -   �  �  �    �     �     �     �  i   �    ^  ]   f     �     �  t   �  �  E  �     J   �  �     .  �     �     �  �  	   C   �!      "     	"     "     1"     5"     E"     M"     h"     �"     �"     �"    �"     �#     �#     �#     �#  
   �#     �#     $     $     $  �   0$     %  
   %     $%     4%     J%     j%     �%     �%     �%     �%     �%     &     &     &  ~   &     �&     �&     �&     �&     �&     '     )'     >'  (   U'    ~'     �(  	   �(     �(     �(     �(     �(  (   �(     �(  C   �(  -  A)  7  o,     �-     �-  $   �-  �   .  �  �.  Q   !1     s1     |1  v   �1        ,   :   5                "   J   $              1   *      2   3   =   	      B   F                  
              &   /             ?             !   6          +   '   )      A         %               9       .   E   C          L   8   7         -              K      0   #                     4       G   @              H   D          (             I   >   <   ;    <strong>Force</strong><br> Send the headers telling the phone to go into auto answer mode. This may not work, and is dependant on the phone. <strong>Reject</strong><br> Return a BUSY signal to the caller <strong>Ring</strong><br> Treat the page as a normal call, and ring the extension (if Call Waiting is disabled, this will return BUSY <ul>
<li><b>"Skip"</b> will not page any busy extension. All other extensions will be paged as normal</li>
<li><b>"Force"</b> will not check if the device is in use before paging it. This means conversations can be interrupted by a page (depending on how the device handles it). This is useful for "emergency" paging groups.</li>
<li><b>"Whisper"</b> will attempt to use the ChanSpy capability on SIP channels, resulting in the page being sent to the device's earpiece "whispered" to the user but not heard by the remote party. If ChanSpy is not supported on the device or otherwise fails, no page will get through. It probably does not make too much sense to choose duplex if using Whisper mode.</li>
</ul> Actions Add Page Group Allows creation of paging groups to make announcements using the speaker built into most SIP phones.		Also creates an Intercom feature code that can be used as a prefix to talk directly to one person, as well as optional feature codes to block/allow intercom calls to all users as well as blocking specific users or only allowing specific users. Annoucement to be played to remote party. Default is a beep Announcement Applications Auto-answer defaults Beep Busy Extensions Default Default Group Inclusion Default Page Group Delete Description Device List Devices to page. Please note, paging calls the actual device (and not the user). Amount of pagable devices is restricted by the advanced setting key PAGINGMAXPARTICIPANTS and is currently set to  Disable Disabled Drop Silence Duplex Enabled Exclude Extension Options Force Group Description If you choose to make a Page Group the "default" page group, a checkbox will appear in the Extensions Module that will allow you to include or exclude that Extension in the default Page Group when editing said extension Include Intercom Intercom Mode Intercom Override Intercom from %s: Disabled Intercom from %s: Enabled Intercom prefix Intercom: Disabled Intercom: Enabled Internal Auto Answer List Page Groups No None Not Selected Override the speaker volume for this page. Note: This is only valid for Sangoma phones at this time Page Group Page Group:  Page Group: %s (%s) Page Groups Paging Extension Paging Group %s : %s Paging Groups Paging and Intercom Paging and Intercom settings Paging is typically one way for announcements only. Checking this will make the paging duplex, allowing all phones in the paging group to be able to talk and be heard by all. This makes it like an "instant conference" Reject Reset Ring Selected Settings Skip Speaker Volume Override Submit The number users will dial to page this group This module is for specific phones that are capable of Paging or Intercom. This section is for configuring group paging, intercom is configured through <strong>Feature Codes</strong>. Intercom must be enabled on a handset before it will allow incoming calls. It is possible to restrict incoming intercom calls to specific extensions only, or to allow intercom calls from all extensions but explicitly deny from specific extensions.<br /><br />This module should work with Aastra, Grandstream, Linksys/Sipura, Mitel, Polycom, SNOM , and possibly other SIP phones (not ATAs). Any phone that is always set to auto-answer should also work (such as the console extension if configured). This option drops what Asterisk detects as silence from entering into the bridge. Enabling this option will drastically improve performance and help remove the buildup of background noise from the conference. Highly recommended for large conferences due to its performance enhancements. Unknown Request User Intercom Allow User Intercom Disallow When Enabled users can use *80<ext> to force intercom. When Disabled this user will reject intercom calls When set to Intercom, calls to this extension/user from other internal users act as if they were intercom calls meaning they will be auto-answered if the endpoint supports this feature and the system is configured to operate in this mode. All the normal white list and black list settings will be honored if they are set. External calls will still ring as normal, as will certain other circumstances such as blind transfers and when a Follow Me is configured and enabled. If Disabled, the phone rings as a normal phone. When using Intercom to page an extension, if the extension is in use, you have three options. Whisper Yes You can include or exclude this extension/device from being part of the default page group when creating or editing. Project-Id-Version: PACKAGE VERSION
Report-Msgid-Bugs-To: 
POT-Creation-Date: 2020-08-20 03:43+0000
PO-Revision-Date: 2016-12-14 21:54+0200
Last-Translator: Alexander <alexander.schley@paranagua.pr.gov.br>
Language-Team: Portuguese (Brazil) <http://weblate.freepbx.org/projects/freepbx/paging/pt_BR/>
Language: pt_BR
MIME-Version: 1.0
Content-Type: text/plain; charset=UTF-8
Content-Transfer-Encoding: 8bit
Plural-Forms: nplurals=2; plural=n != 1;
X-Generator: Weblate 2.4
 <Strong>Forçar</strong><br>Enviar os cabeçalhos indicando ao telefone para entrar no modo de atendimento automático. Isso pode não funcionar e depende do telefone. <Strong>Rejeitar</strong><br>Devolve um sinal OCUPADO ao usuário chamador <Strong>Tocar</strong><br>Trata o a chamada interfonada como uma chamada normal e tocará no ramal (se a Chamada em espera estiver desativada, retornará OCUPADO <ul>
<li><b>"Ignorar"</b> não exibirá nenhum ramal ocupado. Todas os outros ramais serão chamados de forma normal </li>
<li><b>"Forçar"</b> não verificará se o dispositivo está em uso antes de chamá-lo. Isso significa que as conversas podem ser interrompidas por um chamado de interfonia (dependendo de como o dispositivo o manipula). Isso é útil para grupos de "interfonia de emergência". </li>
<li><b>"Sussurro"</b> tentará usar o recurso ChanSpy nos canais SIP, resultando no chamado de interfonia sendo enviado para o fone de ouvido do dispositivo "sussurrado" ao usuário, mas não ouvida pela parte remota. Se o ChanSpy não for suportado no dispositivo ou caso falhe, nenhuma chamado de interfonia passará. Provavelmente não faz muito sentido escolher duplex se usar o modo Susurro.</li>
</ul> Ações Adicionar Grupo de Interfonia Permite a criação de grupos de intefonia para fazer anúncios usando o alto-falante incorporado na maioria dos telefones SIP.		 Também cria um código de recurso de interfone que pode ser usado como um prefixo para falar diretamente com uma pessoa, bem como códigos de recurso opcionais para bloquear/permitir a interfonia de todos os usuários, bem como bloquear usuários específicos ou somente permitir usuários específicos. Anúncio a ser reproduzido para a parte remota. O padrão é um bip Anúncio Aplicações Auto-Responder por padrão Bip Ramais Ocupados Padrão Inclusão de Grupo Padrão Grupo de Interfonia Padrão Apagar Descrição Lista de Dispositivos Dispositivos para a interfonia. Observe, os chamados de interfonia chamam o dispositivo real (e não o usuário). A quantidade de dispositivos "interfonáveis" é restringida pela chave de configuração avançada PAGINGMAXPARTICIPANTS e está atualmente definida como  Desabilitar Desabilitado Ficar em Silêncio Duplex Habilitado Excluir Opções de Ramal Forçar Descrição do Grupo Se você optar por fazer um Grupo de Interfonia "padrão", uma caixa de seleção aparecerá no Módulo de Ramais que permitirá que você inclua ou exclua essa ramal no Grupo de Interfonia padrão ao editar o referido ramal Incluir Interfonia Modo Interfonia Substituir Interfonia Interfonia  de %s: Desabilitada Interfonia de %s: Habilitada Prefixo de Interfonia Interfonia: Desabilitado Interfonia: Habilitado Auto-Resposta Interna Lista de Grupos de Interfonia Não Nenhum Não Selecionado Substitui o volume do alto-falante para este interfone. Observação: isso só é válido para telefones Sangoma neste momento Grupo de Interfonia Grupo de Interfonia:  Grupo de Interfonia: %s (%s) Grupos de Interfonia Ramal de Interfonia Grupo de Interfonia %s : %s Grupos de Interfonia Megafonia e Interfonia Configuração de Megafonia e Interfonia A megafonia é normalmente uma forma de fazer anúncios. Selecionando isso fará a comunicação duplex, permitindo que todos os telefones no grupo de interfonia/megafonia sejam capazes de falar e serem ouvidos por todos. Fazendo que seja como uma "conferência instantânea" Rejeitar Reiniciar Tocar Selecionado Configurações Pular Substituição do volume do auto-falante Enviar Número de usuários que discará para a interfonar para este grupo Este módulo é para telefones específicos que são capazes de realizar chamados por megafone ou interfone. Esta seção é para configurar os grupos de interfonia, o interfone é configurado através de <strong>Códigos de Recurso</strong>. A interfonia deve ser ativada em um aparelho antes de permitir chamadas de entrada. É possível restringir chamadas de interfonia de entrada apenas para ramais específicos, ou permitir chamadas de interfonia de todos os ramais, mas negar explicitamente de ramais específicos. <br/><br/> Este módulo deve trabalhar com Aastra, Grandstream, Linksys/Sipura, Mitel, Polycom, SNOM, e, possivelmente, outros telefones SIP (não ATAs). Qualquer telefone que esteja sempre configurado para resposta automática também deve funcionar (como ramal do console, se configurado). Esta opção causa a queda do que o Asterisk detectar como silêncio ao entrar na ponte. A ativação desta opção melhorará drasticamente o desempenho e ajudará a remover o acúmulo de ruído de fundo da conferência. Altamente recomendado para grandes conferências devido às suas melhorias de desempenho. Solicitação Desconhecida Permitir Usuário de Interfonia Não Permitir Usuário de Interfonia Quando os usuários habilitados podem usar *80<ext> para forçar a interfonia. Quando Desativado, este utilizador irá rejeitar chamadas de interfonia Quando configurado para interfonia, as chamadas para este ramal/usuário de outros usuários internos agem como se fossem chamadas de interfonia, o que significa que serão respondidas automaticamente se o ponto de extremidade suportar esse recurso e o sistema estiver configurado para operar nesse modo. Todas as configurações normais da lista branca e da lista negra serão honradas se estiverem definidas. As chamadas externas continuarão a tocar normalmente, assim como em outras circunstâncias, tais como transferências cegas e quando um Siga-me estiver configurado e ativado. Se Desativado, o telefone toca como um telefone normal. Ao interfonar para um ramal, se o ramal estiver em uso, você tem três opções. Sussurar Sim Você pode incluir ou excluir este ramal/dispositivo de fazer parte do grupo de interfonia padrão ao criar ou editar. 