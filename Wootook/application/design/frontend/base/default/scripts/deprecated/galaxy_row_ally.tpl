
<a style="cursor:pointer" onmouseover="
this.T_WIDTH=250;
this.T_OFFSETX=-30;
this.T_OFFSETY=-30;
this.T_STICKY=true;
this.T_TEMP=5000;
return escape('&lt;table width=\'240\'&gt;&lt;tr&gt;&lt;td class=\'c\'&gt;<?php echo $this->getData('AllyInfoText')?>&lt;/td&gt;&lt;/tr&gt;&lt;th&gt;&lt;table&gt;&lt;tr&gt;&lt;td&gt;&lt;a href=\'alliance.php?mode=ainfo&a=<?php echo $this->getData('ally_id')?>\'&gt;Ver pagina de alianza&lt;/a&gt;&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td&gt;&lt;a href=\'stat.php?start=<?php echo $this->getData('ally_rank')?>&who=ally\'&gt;Ver en estadisticas&lt;/a&gt;&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td&gt;&lt;a href=\'<?php echo $this->getData('ally_web')?>\' target=\'_new\'&gt;Pagina principal de la alianza&lt;/td&gt;&lt;/tr&gt;&lt;/table&gt;&lt;/th&gt;&lt;/table&gt;');">
<?php echo $this->getData('ally_tag')?></a>
