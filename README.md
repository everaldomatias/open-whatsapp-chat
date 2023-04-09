# Open WhatsApp Chat #

**Contributors:** everaldomatias

**Tags:** wordpress, whatsapp, plugin, php, chat

**Stable tag:** 2.0.0

**Donate link:** https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=48LLGK4VPXMBJ

**Requires at least:** 4.5

**Tested up to:** 4.5

**Requires PHP:** 7.0

**License:** GPLv2 or later

**License URI:** http://www.gnu.org/licenses/gpl-2.0.html

Plugin WordPress para adicionar um simples botão para abrir o WhatsApp chat em seu site.

_WordPress plugin to add a simple button to open WhatsApp chat in your site._

##  Porque o plugin foi removido do repositório oficial do WordPress? ##
Recentemente a empresa proprietária do WhatsApp entrou em contato com a equipe o WordPress solicitando a remoção de aproximadamente 1500 plugins de seu repositório, justamente (e apenas) porque utilizam a palavra "WhatsApp".

Como o foco do plugin é auxiliar as pessoas que utilizam essa ferramenta, eu optei por remover o plugin do repositório oficial do WordPress, pois tentar alterar o nome do plugin me colocaria em risco de perder meu perfil no WordPress. Entre manter uma ferramenta que auxília a utilização do WhatsApp (no WordPress) e me manter como parte da comunidade WordPress... sem dúvidas que o WhatsApp nem era uma opção para mim.

Com isso, mantenho o plugin aqui no Github e continuarei a aperfeiçoá-lo de acordo com as necessidades e feedback de quem o utiliza.

### _Why was the plugin removed from the official WordPress repository?_ ###
Recently the company that owns WhatsApp contacted the WordPress team requesting the removal of approximately 1500 plugins from its repository, precisely (and only) because they use the word "WhatsApp".

As the focus of the plugin is to help people using this tool, I chose to remove the plugin from the official WordPress repository because trying to change the plugin name would put me at risk of losing my WordPress profile. Between keeping a tool that helps me use WhatsApp (in WordPress) and keeping me as part of the WordPress community ... no doubt that WhatsApp wasn't even an option for me.

With this, I keep the plugin here on Github and will continue to improve it according to the needs and feedback of those who use it.

## Changelog ##

#### 3.3.0 - 2023-04-09 ####
- Fix button CSS
- Fix PHP error when numbers is empty on admin
- Remove unused code from wp_localize_script

#### 3.2.0 - 2023-02-28 ####
- Add .po .mo to language pt_BR

#### 3.1.0 - 2023-02-28 ####
- Use only default API (https://api.whatsapp.com/send?phone=) and fix description field on admin

#### 3.0.0 - 2023-02-27 ####
- Add option to not show button using exception page URL and add shortcut ['title'] to print page title on message

#### 2.0.0 - 2020-08-11 ####
- Add option to use more than one WhatsApp number (which are stored in a queue and displayed one by one each click on the button)
 
#### 1.0.3 - 2019-10-08 ####
- Update readme (and README.md) with new infos 

#### 1.0.2 - 2019-06-27 ####
- Localization - Added .pot file
