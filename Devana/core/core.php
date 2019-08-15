<?php
if ($benchmark) $startTime=misc::microTime();
$db=new db();
$db->create($dbHost, $dbUser, $dbPass, $dbName);
class db
{
 private $db;
 public function create($dbHost, $dbUser, $dbPass, $dbName)
 {
  $this->db=new mysqli($dbHost, $dbUser, $dbPass, $dbName);
  if ($this->db->connect_error) die('Connect Error ('.$this->db->connect_errno .') '.$mysqli->connect_error);
  //$this->db->query("set global transaction isolation level serializable", $this->db);
 }
 public function query($query)
 {
  if ($result=$this->db->query($query)) return $result;
  else echo $this->db->error;
 }
 public static function fetch($result)
 {
  return $result->fetch_array(MYSQLI_ASSOC);
 }
 public function real_escape_string($string)
 {
  return $this->db->real_escape_string($string);
 }
 public function affected_rows()
 {
  return $this->db->affected_rows;
 }
}
 
class misc
{
 public static function clean($data, $type=0)
 {
  global $db;
  if (is_array($data))
   foreach ($data as $key=>$value)
   {
    if (($type)&&($type=='numeric'))
     if (!is_numeric($value)) $value=0;
     else $value=floor(abs($value));
    $value=$db->real_escape_string($value);
    $data[$key]=htmlspecialchars($value);
   }
  else
  {
   if (($type)&&($type=='numeric'))
    if (!is_numeric($data)) $data=0;
    else $data=floor(abs($data));
   $data=$db->real_escape_string($data);
   $data=htmlspecialchars($data);
  }
  return $data;
 }
 public static function showMessage($message)
 {
  return '<div class="container" style="cursor: pointer;" onClick="this.style.display=\'none\'"><div class="message">'.$message.'</div></div>';
 }
 public static function newId($type)
 {
  global $db;
  $result=$db->query('select min(id) as id from free_ids where type="'.$type.'"');
  $id=db::fetch($result);
  if (isset($id['id']))
  {
   $db->query('delete from free_ids where id="'.$id['id'].'" and type="'.$type.'"');
   return $id['id'];
  }
  else
  {
   $result=$db->query('select max(id) as id from '.$type);
   $id=db::fetch($result);
   if (isset($id['id'])) return $id['id']+1;
   else return 1;
  }
 }
 public static function sToHMS($seconds)
 {
  $h=floor($seconds/3600);
  $m=floor($seconds%3600/60);
  $s=$seconds%3600%60;
  return array($h, $m, $s);
 }
 public static function microTime()
 {
  list($usec, $sec)=explode(" ", microtime());
  return ((float)$usec+(float)$sec);
 }
}

class flags
{
 public static function get($index)
 {
  global $db;
  $result=$db->query('select * from flags');
  $flags=array();
  if ($index=='name')
   while ($row=db::fetch($result)) $flags[$row['name']]=$row['value'];
  else
   for ($i=0; $row=db::fetch($result); $i++) $flags[$i]=$row;
  return $flags;
 }
 public static function set($name, $value)
 {
  global $db;
  $db->query('update flags set value="'.$value.'" where name="'.$name.'"');
  if ($db->affected_rows()>-1) $status='done';
  else $status='error';
  return $status;
 }
}

class blacklist
{
 public static function check($type, $value)
 {
  global $db;
  $result=$db->query('select count(*) as count from blacklist where type="'.$type.'" and value="'.$value.'"');
  $row=db::fetch($result);
  return $row['count'];
 }
 public static function get($type)
 {
  global $db;
  $result=$db->query('select * from blacklist where type="'.$type.'"');
  $blacklist=array();
  for ($i=0; $row=db::fetch($result); $i++) $blacklist[$i]=$row;
  return $blacklist;
 }
 public static function add($type, $value)
 {
  global $db;
  if (!blacklist::check($type, $value))
  {
   $db->query('insert into blacklist (type, value) values ("'.$type.'", "'.$value.'")');
   if ($db->affected_rows()>-1) $status='done';
   else $status='error';
  }
  else $status='duplicateEntry';
  return $status;
 }
 public static function remove($type, $value)
 {
  global $db;
  if (blacklist::check($type, $value))
  {
   $db->query('delete from blacklist where type="'.$type.'" and value="'.$value.'"');
   if ($db->affected_rows()>-1) $status='done';
   else $status='error';
  }
  else $status='noEntry';
  return $status;
 }
}

class activation
{
 public $data;
 public function get($user)
 {
  global $db;
  $result=$db->query('select * from activations where user="'.$user.'"');
  $this->data=db::fetch($result);
  if (isset($this->data['user'])) $status='done';
  else $status='noActivation';
  return $status;
 }
 public function add()
 {
  global $db;
  $db->query('insert into activations (user, code) values ("'.$this->data['user'].'", "'.$this->data['code'].'")');
  if ($db->affected_rows()>-1) $status='done';
  else $status='error';
  return $status;
 }
 public function activate($code)
 {
  global $db;
  if ($this->data['code']==$code)
  {
   $ok=1;
   $db->query('update users set level=level+1 where id="'.$this->data['user'].'"');
   if ($db->affected_rows()==-1) $ok=0;
   $db->query('delete from activations where user="'.$this->data['user'].'"');
   if ($db->affected_rows()==-1) $ok=0;
   if ($ok) $status='done';
   else $status='error';
  }
  else $status='wrongCode';
  return $status;
 }
}

class grid
{
 public $data=array();
 public function get($x, $y)
 {
  global $db;
  $result=$db->query('select * from grid where (y between '.($y-3).' and '.($y+3).')  and (x between '.($x-3).' and '.($x+3).') order by y desc, x asc');
  for ($i=0; $row=db::fetch($result); $i++) $this->data[$i]=$row;
 }
 public function getAll()
 {
  global $db;
  $result=$db->query('select * from grid order by y desc, x asc');
  for ($i=0; $row=db::fetch($result); $i++) $this->data[$i]=$row;
 }
 public static function getSector($x, $y)
 {
  global $db;
  $result=$db->query('select * from grid where x="'.$x.'" and y="'.$y.'"');
  $sector=db::fetch($result);
  return $sector;
 }
 public function getSectorImage($x, $y, &$i, $template)
 {
  global $shortTitle;
  if ((isset($this->data[$i]))&&($this->data[$i]['x']==$x)&&($this->data[$i]['y']==$y))
   if ($this->data[$i]['type']!=2)
   {
    $output='templates/'.$template.'/images/grid/env_'.$this->data[$i]['type'].$this->data[$i]['id'].'.png';
    if ($i<count($this->data)-1) $i++;
   }
   else
   {
    $output='templates/'.$template.'/images/grid/env_'.$this->data[$i]['type'].'2.png';
    if ($i<count($this->data)-1) $i++;
   }
  else $output='templates/'.$template.'/images/grid/env_x.png';
  return $output;
 }
 public function getSectorLink($x, $y, &$i)
 {
  if ((isset($this->data[$i]))&&($this->data[$i]['x']==$x)&&($this->data[$i]['y']==$y))
  {
   if ($this->data[$i]['type']!=2) $output='href="javascript: fetch(\'getGrid.php\', \'x='.$x.'&y='.$y.'\')" onMouseOver="setSectorData(labels['.$this->data[$i]['type'].'], \'-\', \'-\')" onMouseOut="setSectorData(\'-\', \'-\', \'-\')"';
   else
   {
    $node=new node(); $node->get('id', $this->data[$i]['id']);
    $user=new user(); $user->get('id', $node->data['user']);
    $output='href="javascript: fetch(\'getGrid.php\', \'x='.$x.'&y='.$y.'\')" onMouseOver="setSectorData(\''.$node->data['name'].'\', \''.$user->data['name'].'\', \'-\')" onMouseOut="setSectorData(\'-\', \'-\', \'-\')"';
   }
   if ($i<count($this->data)-1) $i++;
  }
  else $output='href="javascript: fetch(\'getGrid.php\', \'x='.$x.'&y='.$y.'\')"';
  return $output;
 }
}

class user
{
 public $data, $preferences, $blocklist;
 public function get($idType, $id)
 {
  global $db;
  $result=$db->query('select * from users where '.$idType.'="'.$id.'"');
  $this->data=db::fetch($result);
  if (isset($this->data['id'])) $status='done';
  else $status='noUser';
  return $status;
 }
 public function set()
 {
  global $db;
  $user=new user();
  if ($user->get('id', $this->data['id'])=='done')
  {
   $db->query('update users set name="'.$this->data['name'].'", password="'.$this->data['password'].'", email="'.$this->data['email'].'", level="'.$this->data['level'].'", joined="'.$this->data['joined'].'", lastVisit="'.$this->data['lastVisit'].'", ip="'.$this->data['ip'].'", alliance="'.$this->data['alliance'].'", template="'.$this->data['template'].'", locale="'.$this->data['locale'].'", sitter="'.$this->data['sitter'].'" where id="'.$this->data['id'].'"');
   if ($db->affected_rows()>-1) $status='done';
   else $status='error';
  }
  else $status='noUser';
  return $status;
 }
 public function add()
 {
  global $db, $game;
  $user=new user();
  if ($user->get('name', $this->data['name'])=='noUser')
   if ($user->get('email', $this->data['email'])=='noUser')
    if (!blacklist::check('ip', $this->data['ip']))
     if (!blacklist::check('email', $this->data['email']))
     {
      $ok=1;
      $this->data['id']=misc::newId('users');
      $db->query('insert into users (id, name, password, email, level, joined, lastVisit, ip, template, locale) values ("'.$this->data['id'].'", "'.$this->data['name'].'", "'.$this->data['password'].'", "'.$this->data['email'].'", "'.$this->data['level'].'", "'.$this->data['joined'].'", "'.$this->data['lastVisit'].'", "'.$this->data['ip'].'", "'.$this->data['template'].'", "'.$this->data['locale'].'")');
      if ($db->affected_rows()==-1) $ok=0;
      $preferences=array();
      foreach ($game['users']['preferences'] as $key=>$preference)
       $preferences[]='("'.$this->data['id'].'", "'.$key.'", "'.$preference.'")';
      $preferences=implode(', ', $preferences);
      $db->query('insert into preferences (user, name, value) values '.$preferences);
      if ($db->affected_rows()==-1) $ok=0;
      if ($ok) $status='done';
      else $status='error';
     }
     else $status='emailBanned';
    else $status='ipBanned';
   else $status='emailInUse';
  else $status='nameTaken';
  return $status;
 }
 public static function remove($id)
 {
  global $db;
  $user=new user();
  if ($user->get('id', $id)=='done')
  {
   $result=$db->query('select id from alliances where user="'.$id.'"');
   while ($row=db::fetch($result)) alliance::remove($row['id']);
   $result=$db->query('select id from nodes where user="'.$id.'"');
   while ($row=db::fetch($result)) node::remove($row['id']);
    $ok=1;
   $db->query('delete from activations where user="'.$id.'"');
   $db->query('delete from preferences where user="'.$id.'"');
   $db->query('delete from blocklist where to="'.$id.'" or from="'.$id.'"');
   $messagesResult=$db->query('select id from messages where recipient="'.$id.'" or sender="'.$id.'"');
   while ($row=db::fetch($messagesResult))
   {
    $db->query('insert into free_ids (id, type) values ("'.$row['id'].'", "messages")');
    if ($db->affected_rows()==-1) $ok=0;
    $db->query('delete from messages where id="'.$row['id'].'"');
    if ($db->affected_rows()==-1) $ok=0;
   }
   $db->query('insert into free_ids (id, type) values ("'.$id.'", "users")');
   if ($db->affected_rows()==-1) $ok=0;
   $db->query('delete from users where id="'.$id.'"');
   if ($db->affected_rows()==-1) $ok=0;
   if ($ok) $status='done';
   else $status='error';
  }
  else $status='noUser';
  return $status;
 }
 public static function removeInactive($maxIdleTime)
 {
  global $db;
  $fromWhen=time()-$maxIdleTime*86400;
  $fromWhen=strftime('%Y-%m-%d %H:%M:%S', $fromWhen);
  $usersResult=$db->query('select id from users where (lastVisit<"'.$fromWhen.'" or level=0) and level<2');
  $pendingCount=$removedCount=0;
  while ($userRow=db::fetch($usersResult))
  {
   $pendingCount++;
   $result=$db->query('select id from nodes where user="'.$userRow['id'].'"');
   while ($row=db::fetch($result)) node::remove($row['id']);
    $ok=1;
   $db->query('delete from activations where user="'.$userRow['id'].'"');
   $messagesResult=$db->query('select id from messages where recipient="'.$userRow['id'].'" or sender="'.$userRow['id'].'"');
   while ($row=db::fetch($messagesResult))
   {
    $db->query('insert into free_ids (id, type) values ("'.$row['id'].'", "messages")');
    if ($db->affected_rows()==-1) $ok=0;
    $db->query('delete from messages where id="'.$row['id'].'"');
    if ($db->affected_rows()==-1) $ok=0;
   }
   $db->query('insert into free_ids (id, type) values ("'.$userRow['id'].'", "users")');
   if ($db->affected_rows()==-1) $ok=0;
   $db->query('delete from users where id="'.$userRow['id'].'"');
   if ($db->affected_rows()==-1) $ok=0;
   if ($ok) $status='done';
   else $status='error';
   if ($ok) $removedCount++;
  }
  return array('found'=>$pendingCount, 'removed'=>$removedCount);
 }
 public function resetPassword($email, $newPass)
 {
  global $db, $game;
  if ($this->data['email']==$email)
   if (time()-strtotime($this->data['lastVisit'])>=$game['users']['passwordResetIdle']*60)
   {
    $this->data['lastVisit']=strftime('%Y-%m-%d %H:%M:%S', time());
    $db->query('update users set password=sha1("'.$newPass.'"), lastVisit="'.$this->data['lastVisit'].'" where id="'.$this->data['id'].'"');
    if ($db->affected_rows()>-1) $status='done';
    else $status='error';
   }
   else $status='tryAgain';
  else $status='wrongEmail';
  return $status;
 }
 public function getPreferences($index)
 {
  global $db;
  $result=$db->query('select * from preferences where user="'.$this->data['id'].'"');
  $this->preferences=array();
  if ($index=='name')
   while ($row=db::fetch($result)) $this->preferences[$row['name']]=$row['value'];
  else
   for ($i=0; $row=db::fetch($result); $i++) $this->preferences[$i]=$row;
 }
 public function setPreference($name, $value)
 {
  global $db;
  $db->query('update preferences set value="'.$value.'" where user="'.$this->data['id'].'" and name="'.$name.'"');
  if ($db->affected_rows()>-1) $status='done';
  else $status='error';
  return $status;
 }
 public function getBlocklist()
 {
  global $db;
  $result=$db->query('select * from blocklist where recipient="'.$this->data['id'].'"');
  $this->blocklist=array();
  $user=new user();
  for ($i=0; $row=db::fetch($result); $i++)
  {
   $this->blocklist[$i]=$row;
   if ($user->get('id', $this->blocklist[$i]['sender'])=='done') $this->blocklist[$i]['senderName']=$user->data['name'];
   else $this->blocklist[$i]['senderName']='[x]';
  }
 }
 public function isBlocked($recipient)
 {
  global $db;
  $result=$db->query('select count(*) as count from blocklist where recipient="'.$recipient.'" and sender="'.$this->data['id'].'"');
  $row=db::fetch($result);
  return $row['count'];
 }
 public function setBlocklist($name)
 {
  global $db;
  $user=new user();
  if ($user->get('name', $name)=='done')
  {
   $result=$db->query('select count(*) as count from blocklist where recipient="'.$this->data['id'].'" and sender="'.$user->data['id'].'"');
   $row=db::fetch($result);
   if ($row['count'])
    $db->query('delete from blocklist where recipient="'.$this->data['id'].'" and sender="'.$user->data['id'].'"');
   else
    $db->query('insert into blocklist (recipient, sender) values ("'.$this->data['id'].'", "'.$user->data['id'].'")');
   if ($db->affected_rows()>-1) $status='done';
   else $status='error';
  }
  else $status='noUser';
  return $status;
 }
}

class node
{
 public $data, $location, $resources, $production, $storage, $technologies, $modules, $components, $queue=array('research', 'build', 'craft', 'train', 'trade');
 public function get($idType, $id)
 {
  global $db;
  $result=$db->query('select * from nodes where '.$idType.'="'.$id.'"');
  $this->data=db::fetch($result);
  if (isset($this->data['id'])) $status='done';
  else $status='noNode';
  return $status;
 }
 public function set()
 {
  global $db, $game;
  $this->getResources();
  $setCost=$game['factions'][$this->data['faction']]['costs']['set'];
  $setCostData=$this->checkCost($setCost, 'set');
  if ($setCostData['ok'])
  {
   $node=new node();
   if ($node->get('id', $this->data['id'])=='done')
    if (($node->data['name']==$this->data['name'])||($node->get('name', $this->data['name'])=='noNode'))
    {
     $ok=1;
     foreach ($setCost as $cost)
     {
      $this->resources[$cost['resource']]['value']-=$cost['value']*$game['users']['cost']['set'];
      $db->query('update resources set value="'.$this->resources[$cost['resource']]['value'].'" where node="'.$this->data['id'].'" and id="'.$cost['resource'].'"');
      if ($db->affected_rows()==-1) $ok=0;
     }
     $db->query('update nodes set name="'.$this->data['name'].'", focus="'.$this->data['focus'].'" where id="'.$this->data['id'].'"');
     if ($db->affected_rows()==-1) $ok=0;
     if ($ok) $status='done';
     else $status='error';
    }
    else $status='nameTaken';
   else $status='noNode';
  }
  else $status='notEnoughResources';
  return $status;
 }
 public function add($userId)
 {
  global $db, $game, $shortTitle;
  $sector=grid::getSector($this->location['x'], $this->location['y']);
  $node=new node(); $status=0;
  if ($sector['type']==1)
   if ($node->get('name', $this->data['name'])=='noNode')
   {
    $nodes=node::getList($userId);
    if (count($nodes)<$game['users']['nodes'])
    {
     $ok=1;
     $this->data['id']=misc::newId('nodes');
     $db->query('insert into nodes (id, faction, user, name, focus, lastCheck) values ("'.$this->data['id'].'", "'.$this->data['faction'].'", "'.$this->data['user'].'", "'.$this->data['name'].'", "hp", now())');
     if ($db->affected_rows()==-1) $ok=0;
     $db->query('update grid set type="2", id="'.$this->data['id'].'" where x="'.$this->location['x'].'" and y="'.$this->location['y'].'"');
     if ($db->affected_rows()==-1) $ok=0;
     $query=array();
     $nr=count($game['resources']);
     for ($i=0; $i<$nr; $i++) $query[$i]='("'.$this->data['id'].'", "'.$i.'", "'.$game['factions'][$this->data['faction']]['storage'][$i].'")';
     $db->query('insert into resources (node, id, value) values '.implode(', ', $query));
     if ($db->affected_rows()==-1) $ok=0;
     $query=array();
     $nr=count($game['technologies'][$this->data['faction']]);
     for ($i=0; $i<$nr; $i++) $query[$i]='("'.$this->data['id'].'", "'.$i.'", "0")';
     $db->query('insert into technologies (node, id, value) values '.implode(', ', $query));
     if ($db->affected_rows()==-1) $ok=0;
     $query=array();
     for ($i=0; $i<$game['factions'][$this->data['faction']]['modules']; $i++) $query[$i]='("'.$this->data['id'].'", "'.$i.'", "-1", "0")';
     $db->query('insert into modules (node, slot, module, input) values '.implode(', ', $query));
     if ($db->affected_rows()==-1) $ok=0;
     $query=array();
     $nr=count($game['components'][$this->data['faction']]);
     for ($i=0; $i<$nr; $i++) $query[$i]='("'.$this->data['id'].'", "'.$i.'", "0")';
     $db->query('insert into components (node, id, value) values '.implode(', ', $query));
     if ($db->affected_rows()==-1) $ok=0;
     $query=array();
     $nr=count($game['units'][$this->data['faction']]);
     for ($i=0; $i<$nr; $i++) $query[$i]='("'.$this->data['id'].'", "'.$i.'", "0")';
     $db->query('insert into units (node, id, value) values '.implode(', ', $query));
     if ($db->affected_rows()==-1) $ok=0;
     if ($ok) $status="done";
     else $status='error';
    }
    else $status='maxNodesReached';
   }
   else $status='nameTaken';
  else $status='invalidGridSector';
  return $status;
 }
 public static function remove($id)
 {
  global $db;
  $node=new node();
  if ($node->get('id', $id)=='done')
  {
   $ok=1;
   $node->getLocation();
   $db->query('delete from research where node="'.$id.'"');
   $db->query('delete from build where node="'.$id.'"');
   $db->query('delete from craft where node="'.$id.'"');
   $db->query('delete from train where node="'.$id.'"');
   $db->query('delete from trade where node="'.$id.'"');
   $db->query('delete from combat_units where combat in (select id from combat where sender="'.$id.'" or recipient="'.$id.'")');
   $db->query('delete from combat where sender="'.$id.'" or recipient="'.$id.'"');
   $db->query('delete from resources where node="'.$id.'"');
   if ($db->affected_rows()==-1) $ok=0;
   $db->query('delete from technologies where node="'.$id.'"');
   if ($db->affected_rows()==-1) $ok=0;
   $db->query('delete from modules where node="'.$id.'"');
   if ($db->affected_rows()==-1) $ok=0;
   $db->query('delete from components where node="'.$id.'"');
   if ($db->affected_rows()==-1) $ok=0;
   $db->query('delete from units where node="'.$id.'"');
   if ($db->affected_rows()==-1) $ok=0;
   $db->query('insert into free_ids (id, type) values ("'.$id.'", "nodes")');
   if ($db->affected_rows()==-1) $ok=0;
   $db->query('delete from nodes where id="'.$id.'"');
   if ($db->affected_rows()==-1) $ok=0;
   $db->query('update grid set type="1", id=floor(1+rand()*9) where x="'.$node->location['x'].'" and y="'.$node->location['y'].'"');
   if ($db->affected_rows()==-1) $ok=0;
   if ($ok) $status="done";
   else $status='error';
  }
  else $status='noNode';
  return $status;
 }
 public static function getList($userId)
 {
  global $db;
  $result=$db->query('select * from nodes where user="'.$userId.'"');
  $nodes=array();
  for ($i=0; $row=db::fetch($result); $i++)
  {
   $nodes[$i]=new node();
   $nodes[$i]->data=$row;
  }
  return $nodes;
 }
 public function getLocation()
 {
  global $db;
  $result=$db->query('select x, y from grid where type="2" and id="'.$this->data['id'].'"');
  $row=db::fetch($result);
  if (isset($row['x']))
  {
   $this->location=$row;
   $status='done';
  }
  else $status='noNode';
  return $status;
 }
 public function getResources()
 {
  global $db, $game;
  $this->resources=array();
  $this->storage=$game['factions'][$this->data['faction']]['storage'];
  $this->production=array();
  foreach ($game['resources'] as $key=>$resource)
   $this->production[$key]=0;
  $result=$db->query('select * from resources where node="'.$this->data['id'].'" order by id asc');
  for ($i=0; $row=db::fetch($result); $i++) $this->resources[$i]=$row;
  if ($this->modules)
   foreach ($this->modules as $module)
    if ($module['module']>-1)
     switch ($game['modules'][$this->data['faction']][$module['module']]['type'])
     {
      case 'storage':
       $this->storage[$game['modules'][$this->data['faction']][$module['module']]['storedResource']]+=$game['modules'][$this->data['faction']][$module['module']]['ratio']*$module['input'];
      break;
      case 'harvest':
       $this->production[$game['modules'][$this->data['faction']][$module['module']]['outputResource']]+=$game['modules'][$this->data['faction']][$module['module']]['ratio']*$module['input'];
      break;
     }
 }
 public function getTechnologies()
 {
  global $db;
  $this->technologies=array();
  $result=$db->query('select * from technologies where node="'.$this->data['id'].'" order by id asc');
  for ($i=0; $row=db::fetch($result); $i++) $this->technologies[$i]=$row;
 }
 public function getModules()
 {
  global $db;
  $this->modules=array();
  $result=$db->query('select * from modules where node="'.$this->data['id'].'" order by slot asc');
  while ($row=db::fetch($result)) $this->modules[$row['slot']]=$row;
 }
 public function getComponents()
 {
  global $db;
  $this->components=array();
  $result=$db->query('select * from components where node="'.$this->data['id'].'" order by id asc');
  for ($i=0; $row=db::fetch($result); $i++) $this->components[$i]=$row;
 }
 public function getUnits()
 {
  global $db;
  $this->units=array();
  $result=$db->query('select * from units where node="'.$this->data['id'].'" order by id asc');
  while ($row=db::fetch($result)) $this->units[$row['id']]=$row;
 }
 public function getAll()
 {
  $this->getLocation();
  $this->getResources();
  $this->getTechnologies();
  $this->getModules();
  $this->getComponents();
  $this->getUnits();
 }
 public function getQueue($type, $field=0, $values=0)
 {
  global $db;
  $this->queue[$type]=array();
  switch ($type)
  {
   case 'combat':
    $result=$db->query('select * from '.$type.' where sender="'.$this->data['id'].'" or recipient="'.$this->data['id'].'" order by start asc');
   break;
   default:
    if ($field)
    {
     $values='('.implode(', ', $values).')';
     $result=$db->query('select * from '.$type.' where node="'.$this->data['id'].'" and '.$field.' in '.$values.' order by start asc');
    }
    else $result=$db->query('select * from '.$type.' where node="'.$this->data['id'].'" order by start asc');
   break;
  }
  for ($i=0; $row=db::fetch($result); $i++)
  {
   $this->queue[$type][$i]=$row;
   $this->queue[$type][$i]['start']=strtotime($this->queue[$type][$i]['start']);
  }
 }
 public function addTechnology($technologyId, $slotId)
 {
  global $db, $game;
  $this->getModules();
  $this->getResources();
  $this->getTechnologies();
  $this->getComponents();
  $technology=array();
  if (isset($this->technologies[$technologyId]))
  {
   $okModule=0;
   if (isset($this->modules[$slotId]['module']))
    if (in_array($technologyId, $game['modules'][$this->data['faction']][$this->modules[$slotId]['module']]['technologies']))
     $okModule=1;
   if ($okModule)
    if ($this->technologies[$technologyId]['value']<$game['technologies'][$this->data['faction']][$technologyId]['maxTier'])
    {
     $result=$db->query('select count(*) as count from research where node="'.$this->data['id'].'" and technology="'.$technologyId.'"');
     $row=db::fetch($result);
     if (!$row['count'])
     {
      $technology['requirementsData']=$this->checkRequirements($game['technologies'][$this->data['faction']][$technologyId]['requirements']);
      if ($technology['requirementsData']['ok'])
      {
       $technology['costData']=$this->checkCost($game['technologies'][$this->data['faction']][$technologyId]['cost'], 'research');
       if ($technology['costData']['ok'])
       {
        $ok=1;
        foreach ($game['technologies'][$this->data['faction']][$technologyId]['cost'] as $cost)
        {
         $this->resources[$cost['resource']]['value']-=$cost['value']*$game['users']['cost']['research'];
         $db->query('update resources set value="'.$this->resources[$cost['resource']]['value'].'" where node="'.$this->data['id'].'" and id="'.$cost['resource'].'"');
         if ($db->affected_rows()==-1) $ok=0;
        }
        foreach ($game['technologies'][$this->data['faction']][$technologyId]['requirements'] as $requirement)
         if ($requirement['type']=='components')
         {
          $storageResource=$game['components'][$this->data['faction']][$requirement['id']]['storageResource'];
          $this->resources[$storageResource]['value']+=$game['components'][$this->data['faction']][$requirement['id']]['storage']*$requirement['value'];
          $db->query('update resources set value="'.$this->resources[$storageResource]['value'].'" where node="'.$this->data['id'].'" and id="'.$storageResource.'"');
          if ($db->affected_rows()==-1) $ok=0;
          $this->components[$requirement['id']]['value']-=$requirement['value'];
          $db->query('update components set value="'.$this->components[$requirement['id']]['value'].'" where node="'.$this->data['id'].'" and id="'.$requirement['id'].'"');
          if ($db->affected_rows()==-1) $ok=0;
         }
        $this->getQueue('research', 'technology', $game['modules'][$this->data['faction']][$this->modules[$slotId]['module']]['technologies']);
        $lastResearch=count($this->queue['research'])-1;
        if ($lastResearch>-1) $start=strftime('%Y-%m-%d %H:%M:%S', $this->queue['research'][$lastResearch]['start']+floor($this->queue['research'][$lastResearch]['duration']*60));
        else $start=strftime('%Y-%m-%d %H:%M:%S', time());
        $totalIR=0;
        foreach ($this->modules as $key=>$item)
         if ($item['module']==$this->modules[$slotId]['module']) $totalIR+=$item['input']*$game['modules'][$this->data['faction']][$item['module']]['ratio'];
        $duration=$game['technologies'][$this->data['faction']][$technologyId]['duration'];
        $duration=($duration-$duration*$totalIR)*$game['users']['speed']['research'];
        $db->query('insert into research (node, technology, start, duration) values ("'.$this->data['id'].'", "'.$technologyId.'", "'.$start.'", "'.$duration.'")');
        if ($db->affected_rows()==-1) $ok=0;
        if ($ok) $status='done';
        else $status='error';
       }
       else $status='notEnoughResources';
      }
      else $status='requirementsNotMet';
     }
     else $status='technologyBusy';
    }
    else $status='maxTechnologyTierMet';
   else $status='requirementsNotMet';
  }
  else $status='noTechnology';
  return $status;
 }
 public function cancelTechnology($technologyId, $moduleId)
 {
  global $db, $game;
  $this->getResources();
  $this->getComponents();
  $result=$db->query('select * from research where node="'.$this->data['id'].'" and technology="'.$technologyId.'"');
  $entry=db::fetch($result);
  if (isset($entry['start']))
  {
   $entry['start']=strtotime($entry['start']);
   $ok=1;
   foreach ($game['technologies'][$this->data['faction']][$entry['technology']]['cost'] as $cost)
   {
    $this->resources[$cost['resource']]['value']+=$cost['value']*$game['users']['cost']['research'];
    $db->query('update resources set value="'.$this->resources[$cost['resource']]['value'].'" where node="'.$this->data['id'].'" and id="'.$cost['resource'].'"');
    if ($db->affected_rows()==-1) $ok=0;
   }
   foreach ($game['technologies'][$this->data['faction']][$entry['technology']]['requirements'] as $requirement)
    if ($requirement['type']=='components')
    {
     $storageResource=$game['components'][$this->data['faction']][$requirement['id']]['storageResource'];
     $this->resources[$storageResource]['value']-=$game['components'][$this->data['faction']][$requirement['id']]['storage']*$requirement['value'];
     $db->query('update resources set value="'.$this->resources[$storageResource]['value'].'" where node="'.$this->data['id'].'" and id="'.$storageResource.'"');
     if ($db->affected_rows()==-1) $ok=0;
     $this->components[$requirement['id']]['value']+=$requirement['value'];
     $db->query('update components set value="'.$this->components[$requirement['id']]['value'].'" where node="'.$this->data['id'].'" and id="'.$requirement['id'].'"');
     if ($db->affected_rows()==-1) $ok=0;
    }
   $this->getQueue('research', 'technology', $game['modules'][$this->data['faction']][$moduleId]['technologies']);
   $entry['duration']=floor($entry['duration']*60);
   foreach ($this->queue['research'] as $queueEntry)
    if ($queueEntry['start']>$entry['start'])
    {
     $db->query('update research set start="'.strftime('%Y-%m-%d %H:%M:%S', $queueEntry['start']-$entry['duration']).'" where node="'.$this->data['id'].'" and technology="'.$queueEntry['technology'].'"');
     if ($db->affected_rows()==-1) $ok=0;
    }
   $db->query('delete from research where node="'.$this->data['id'].'" and technology="'.$technologyId.'"');
   if ($db->affected_rows()==-1) $ok=0;
   if ($ok) $status='done';
   else $status='error';
  }
  else $status='noEntry';
  return $status;
 }
 public function setModule($slotId)
 {
  global $db, $game;
  $this->getResources();
  $result=$db->query('select * from modules where node="'.$this->data['id'].'" and slot="'.$slotId.'"');
  $module=db::fetch($result);
  if (isset($module['module']))
   if ($module['module']>-1)
   {
    $result=$db->query('select * from resources where node="'.$this->data['id'].'" and id="'.$game['modules'][$this->data['faction']][$module['module']]['inputResource'].'"');
    $resource=db::fetch($result);
    if ($resource['value']+$module['input']>=$this->modules[$slotId]['input'])
     if ($this->modules[$slotId]['input']<=$game['modules'][$this->data['faction']][$module['module']]['maxInput'])
     {
      $ok=1;
      $this->resources[$resource['id']]['value']+=$module['input']-$this->modules[$slotId]['input'];
      $db->query('update resources set value="'.$this->resources[$resource['id']]['value'].'" where node="'.$this->data['id'].'" and id="'.$resource['id'].'"');
      if ($db->affected_rows()==-1) $ok=0;
      $db->query('update modules set input="'.$this->modules[$slotId]['input'].'" where node="'.$this->data['id'].'" and slot="'.$slotId.'"');
      if ($db->affected_rows()==-1) $ok=0;
      $this->checkModuleDependencies($module['module'], $slotId, 1);
      if ($ok) $status='done';
      else $status='error';
     }
     else $status='maxInputExceeded';
    else $status='notEnoughResources';
   }
   else $status='emptySlot';
  else $status='noSlot';
  return $status;
 }
 public function addModule($slotId, $moduleId)
 {
  global $db, $game;
  $result=$db->query('select * from modules where node="'.$this->data['id'].'" and slot="'.$slotId.'"');
  $module=db::fetch($result);
  if (isset($module['module']))
   if ($module['module']==-1)
   {
    $result=$db->query('select count(*) as count from modules where node="'.$this->data['id'].'" and module="'.$moduleId.'"');
    $row=db::fetch($result);
    if ($row['count']<$game['modules'][$this->data['faction']][$moduleId]['maxInstances'])
    {
     $result=$db->query('select count(*) as count from build where node="'.$this->data['id'].'" and slot="'.$slotId.'"');
     $row=db::fetch($result);
     if (!$row['count'])
     {
      $this->getModules();
      $this->getResources();
      $this->getTechnologies();
      $this->getComponents();
      $module['requirementsData']=$this->checkRequirements($game['modules'][$this->data['faction']][$moduleId]['requirements']);
      if ($module['requirementsData']['ok'])
      {
       $module['costData']=$this->checkCost($game['modules'][$this->data['faction']][$moduleId]['cost'], 'build');
       if ($module['costData']['ok'])
       {
        $ok=1;
        foreach ($game['modules'][$this->data['faction']][$moduleId]['cost'] as $cost)
        {
         $this->resources[$cost['resource']]['value']-=$cost['value']*$game['users']['cost']['build'];
         $db->query('update resources set value="'.$this->resources[$cost['resource']]['value'].'" where node="'.$this->data['id'].'" and id="'.$cost['resource'].'"');
         if ($db->affected_rows()==-1) $ok=0;
        }
        foreach ($game['modules'][$this->data['faction']][$moduleId]['requirements'] as $requirement)
         if ($requirement['type']=='components')
         {
          $storageResource=$game['components'][$this->data['faction']][$requirement['id']]['storageResource'];
          $this->resources[$storageResource]['value']+=$game['components'][$this->data['faction']][$requirement['id']]['storage']*$requirement['value'];
          $db->query('update resources set value="'.$this->resources[$storageResource]['value'].'" where node="'.$this->data['id'].'" and id="'.$storageResource.'"');
          if ($db->affected_rows()==-1) $ok=0;
          $this->components[$requirement['id']]['value']-=$requirement['value'];
          $db->query('update components set value="'.$this->components[$requirement['id']]['value'].'" where node="'.$this->data['id'].'" and id="'.$requirement['id'].'"');
          if ($db->affected_rows()==-1) $ok=0;
         }
        $this->getQueue('build');
        $lastBuild=count($this->queue['build'])-1;
        if ($lastBuild>-1) $start=strftime('%Y-%m-%d %H:%M:%S', $this->queue['build'][$lastBuild]['start']+floor($this->queue['build'][$lastBuild]['duration']*60));
        else $start=strftime('%Y-%m-%d %H:%M:%S', time());
        $db->query('insert into build (node, slot, module, start, duration) values ("'.$this->data['id'].'", "'.$slotId.'", "'.$moduleId.'", "'.$start.'", "'.($game['modules'][$this->data['faction']][$moduleId]['duration']*$game['users']['speed']['build']).'")');
        if ($db->affected_rows()==-1) $ok=0;
        if ($ok) $status='done';
        else $status='error';
       }
       else $status='notEnoughResources';
      }
      else $status='requirementsNotMet';
     }
     else $status='slotBusy';
    }
    else $status='maxModuleInstancesMet';
   }
   else $status='notEmptySlot';
  else $status='noSlot';
  return $status;
 }
 public function removeModule($slotId)
 {
  global $db, $game;
  $result=$db->query('select * from modules where node="'.$this->data['id'].'" and slot="'.$slotId.'"');
  $module=db::fetch($result);
  if (isset($module['module']))
   if ($module['module']>-1)
   {
    $result=$db->query('select count(*) as count from build where node="'.$this->data['id'].'" and slot="'.$slotId.'"');
    $row=db::fetch($result);
    if (!$row['count'])
    {
     $this->getQueue('build');
     $lastBuild=count($this->queue['build'])-1;
     if ($lastBuild>-1) $start=strftime('%Y-%m-%d %H:%M:%S', $this->queue['build'][$lastBuild]['start']+floor($this->queue['build'][$lastBuild]['duration']*60));
     else $start=strftime('%Y-%m-%d %H:%M:%S', time());
     $ok=1;
     $db->query('insert into build (node, slot, module, start, duration) values ("'.$this->data['id'].'", "'.$slotId.'", "'.$module['module'].'", "'.$start.'", "'.($game['modules'][$this->data['faction']][$module['module']]['removeDuration']*$game['users']['speed']['build']).'")');
     if ($db->affected_rows()==-1) $ok=0;
     if ($ok) $status='done';
     else $status='error';
    }
    else $status='slotBusy';
   }
   else $status='emptySlot';
  else $status='noSlot';
  return $status;
 }
 public function cancelModule($slotId)
 {
  global $db, $game;
  $this->getModules();
  $this->getResources();
  $this->getComponents();
  $result=$db->query('select * from build where node="'.$this->data['id'].'" and slot="'.$slotId.'"');
  $entry=db::fetch($result);
  if (isset($entry['start']))
  {
   $entry['start']=strtotime($entry['start']);
   $ok=1;
   if ($this->modules[$slotId==-1])
   {
    foreach ($game['modules'][$this->data['faction']][$entry['module']]['cost'] as $cost)
    {
     $this->resources[$cost['resource']]['value']+=$cost['value']*$game['users']['cost']['build'];
     $db->query('update resources set value="'.$this->resources[$cost['resource']]['value'].'" where node="'.$this->data['id'].'" and id="'.$cost['resource'].'"');
     if ($db->affected_rows()==-1) $ok=0;
    }
    foreach ($game['modules'][$this->data['faction']][$entry['module']]['requirements'] as $requirement)
     if ($requirement['type']=='components')
     {
      $storageResource=$game['components'][$this->data['faction']][$requirement['id']]['storageResource'];
      $this->resources[$storageResource]['value']-=$game['components'][$this->data['faction']][$requirement['id']]['storage']*$requirement['value'];
      $db->query('update resources set value="'.$this->resources[$storageResource]['value'].'" where node="'.$this->data['id'].'" and id="'.$storageResource.'"');
      if ($db->affected_rows()==-1) $ok=0;
      $this->components[$requirement['id']]['value']+=$requirement['value'];
      $db->query('update components set value="'.$this->components[$requirement['id']]['value'].'" where node="'.$this->data['id'].'" and id="'.$requirement['id'].'"');
      if ($db->affected_rows()==-1) $ok=0;
     }
   }
   $this->getQueue('build');
   $entry['duration']=floor($entry['duration']*60);
   foreach ($this->queue['build'] as $queueEntry)
   {
    if ($queueEntry['start']>$entry['start'])
    {
     $db->query('update build set start="'.strftime('%Y-%m-%d %H:%M:%S', $queueEntry['start']-$entry['duration']).'" where node="'.$this->data['id'].'" and slot="'.$queueEntry['slot'].'"');
     if ($db->affected_rows()==-1) $ok=0;
    }
   }
   $db->query('delete from build where node="'.$this->data['id'].'" and slot="'.$slotId.'"');
   if ($db->affected_rows()==-1) $ok=0;
   if ($ok) $status='done';
   else $status='error';
  }
  else $status='noEntry';
  return $status;
 }
 public function addComponent($componentId, $quantity, $slotId)
 {
  global $db, $game;
  $this->getModules();
  $this->getResources();
  $this->getTechnologies();
  $this->getComponents();
  $component=array();
  if (isset($this->components[$componentId]))
  {
   $okModule=0;
   if (isset($this->modules[$slotId]['module']))
    if (in_array($componentId, $game['modules'][$this->data['faction']][$this->modules[$slotId]['module']]['components']))
     $okModule=1;
   if ($okModule)
   {
    $component['requirementsData']=$this->checkRequirements($game['components'][$this->data['faction']][$componentId]['requirements'], $quantity);
    if ($component['requirementsData']['ok'])
     if ($this->resources[$game['components'][$this->data['faction']][$componentId]['storageResource']]['value']>=$game['components'][$this->data['faction']][$componentId]['storage']*$quantity)
     {
      $component['costData']=$this->checkCost($game['components'][$this->data['faction']][$componentId]['cost'], 'craft', $quantity);
      if ($component['costData']['ok'])
      {
       $ok=1;
       $storageResource=$game['components'][$this->data['faction']][$componentId]['storageResource'];
       $this->resources[$storageResource]['value']-=$game['components'][$this->data['faction']][$componentId]['storage']*$quantity;
       $db->query('update resources set value="'.$this->resources[$storageResource]['value'].'" where node="'.$this->data['id'].'" and id="'.$storageResource.'"');
       if ($db->affected_rows()==-1) $ok=0;
       foreach ($game['components'][$this->data['faction']][$componentId]['cost'] as $cost)
       {
        $this->resources[$cost['resource']]['value']-=$cost['value']*$quantity*$game['users']['cost']['craft'];
        $db->query('update resources set value="'.$this->resources[$cost['resource']]['value'].'" where node="'.$this->data['id'].'" and id="'.$cost['resource'].'"');
        if ($db->affected_rows()==-1) $ok=0;
       }
       foreach ($game['components'][$this->data['faction']][$componentId]['requirements'] as $requirement)
        if ($requirement['type']=='components')
        {
         $storageResource=$game['components'][$this->data['faction']][$requirement['id']]['storageResource'];
         $this->resources[$storageResource]['value']+=$game['components'][$this->data['faction']][$requirement['id']]['storage']*$requirement['value']*$quantity;
         $db->query('update resources set value="'.$this->resources[$storageResource]['value'].'" where node="'.$this->data['id'].'" and id="'.$storageResource.'"');
         if ($db->affected_rows()==-1) $ok=0;
         $this->components[$requirement['id']]['value']-=$requirement['value']*$quantity;
         $db->query('update components set value="'.$this->components[$requirement['id']]['value'].'" where node="'.$this->data['id'].'" and id="'.$requirement['id'].'"');
         if ($db->affected_rows()==-1) $ok=0;
        }
       $this->getQueue('craft', 'component', $game['modules'][$this->data['faction']][$this->modules[$slotId]['module']]['components']);
       $lastCraft=count($this->queue['craft'])-1;
       if ($lastCraft>-1) $start=strftime('%Y-%m-%d %H:%M:%S', $this->queue['craft'][$lastCraft]['start']+floor($this->queue['craft'][$lastCraft]['duration']*60));
       else $start=strftime('%Y-%m-%d %H:%M:%S', time());
       $totalIR=0;
       foreach ($this->modules as $key=>$item)
        if ($item['module']==$this->modules[$slotId]['module']) $totalIR+=$item['input']*$game['modules'][$this->data['faction']][$item['module']]['ratio'];
       $duration=$game['components'][$this->data['faction']][$componentId]['duration']*$quantity;
       $duration=($duration-$duration*$totalIR)*$game['users']['speed']['craft'];
       $result=$db->query('select max(id) as id from craft where node="'.$this->data['id'].'"');
       $row=db::fetch($result);
       $id=$row['id']+1;
       $db->query('insert into craft (id, node, component, quantity, stage, start, duration) values ("'.$id.'", "'.$this->data['id'].'", "'.$componentId.'", "'.$quantity.'", 0, "'.$start.'", "'.$duration.'")');
       if ($db->affected_rows()==-1) $ok=0;
       if ($ok) $status='done';
       else $status='error';
      }
      else $status='notEnoughResources';
     }
     else $status='notEnoughStorageResource';
    else $status='requirementsNotMet';
   }
   else $status='requirementsNotMet';
  }
  else $status='noComponent';
  return $status;
 }
 public function removeComponent($componentId, $quantity, $moduleId)
 {
  global $db, $game;
  $this->getModules();
  $this->getResources();
  $this->getComponents();
  $component=array();
  if (isset($this->components[$componentId]))
   if ($this->components[$componentId]['value']>=$quantity)
   {
    $ok=1;
    $storageResource=$game['components'][$this->data['faction']][$componentId]['storageResource'];
    $this->resources[$storageResource]['value']+=$game['components'][$this->data['faction']][$componentId]['storage']*$quantity;
    $db->query('update resources set value="'.$this->resources[$storageResource]['value'].'" where node="'.$this->data['id'].'" and id="'.$storageResource.'"');
    if ($db->affected_rows()==-1) $ok=0;
    $this->components[$componentId]['value']-=$quantity;
    $db->query('update components set value="'.$this->components[$componentId]['value'].'" where node="'.$this->data['id'].'" and id="'.$componentId.'"');
    if ($db->affected_rows()==-1) $ok=0;
    $this->getQueue('craft', 'component', $game['modules'][$this->data['faction']][$moduleId]['components']);
    $lastCraft=count($this->queue['craft'])-1;
    if ($lastCraft>-1) $start=strftime('%Y-%m-%d %H:%M:%S', $this->queue['craft'][$lastCraft]['start']+floor($this->queue['craft'][$lastCraft]['duration']*60));
    else $start=strftime('%Y-%m-%d %H:%M:%S', time());
    $totalIR=0;
    foreach ($this->modules as $key=>$item)
     if ($item['module']==$moduleId) $totalIR+=$item['input']*$game['modules'][$this->data['faction']][$item['module']]['ratio'];
    $duration=$game['components'][$this->data['faction']][$componentId]['removeDuration']*$quantity;
    $duration=($duration-$duration*$totalIR)*$game['users']['speed']['craft'];
    $result=$db->query('select max(id) as id from craft where node="'.$this->data['id'].'"');
    $row=db::fetch($result);
    $id=$row['id']+1;
    $db->query('insert into craft (id, node, component, quantity, stage, start, duration) values ("'.$id.'", "'.$this->data['id'].'", "'.$componentId.'", "'.$quantity.'", 1, "'.$start.'", "'.$duration.'")');
    if ($db->affected_rows()==-1) $ok=0;
    if ($ok) $status='done';
    else $status='error';
   }
   else $status='notEnoughComponents';
  else $status='noComponent';
  return $status;
 }
 public function cancelComponent($craftId, $moduleId)
 {
  global $db, $game;
  $this->getResources();
  $this->getComponents();
  $result=$db->query('select * from craft where id="'.$craftId.'"');
  $entry=db::fetch($result);
  if (isset($entry['start']))
  {
   $entry['start']=strtotime($entry['start']);
   $ok=1;
   $storageResource=$game['components'][$this->data['faction']][$entry['component']]['storageResource'];
   $storage=$game['components'][$this->data['faction']][$entry['component']]['storage']*$entry['quantity'];
   if (!$entry['stage']) $this->resources[$storageResource]['value']+=$storage;
   else $this->resources[$storageResource]['value']-=$storage;
   $db->query('update resources set value="'.$this->resources[$storageResource]['value'].'" where node="'.$this->data['id'].'" and id="'.$storageResource.'"');
   if ($db->affected_rows()==-1) $ok=0;
   if (!$entry['stage'])
   {
    foreach ($game['components'][$this->data['faction']][$entry['component']]['cost'] as $cost)
    {
     $this->resources[$cost['resource']]['value']+=$cost['value']*$entry['quantity']*$game['users']['cost']['craft'];
     $db->query('update resources set value="'.$this->resources[$cost['resource']]['value'].'" where node="'.$this->data['id'].'" and id="'.$cost['resource'].'"');
     if ($db->affected_rows()==-1) $ok=0;
    }
    foreach ($game['components'][$this->data['faction']][$entry['component']]['requirements'] as $requirement)
     if ($requirement['type']=='components')
     {
      $storageResource=$game['components'][$this->data['faction']][$requirement['id']]['storageResource'];
      $this->resources[$storageResource]['value']-=$game['components'][$this->data['faction']][$requirement['id']]['storage']*$requirement['value']*$entry['quantity'];
      $db->query('update resources set value="'.$this->resources[$storageResource]['value'].'" where node="'.$this->data['id'].'" and id="'.$storageResource.'"');
      if ($db->affected_rows()==-1) $ok=0;
      $this->components[$requirement['id']]['value']+=$requirement['value']*$entry['quantity'];
      $db->query('update components set value="'.$this->components[$requirement['id']]['value'].'" where node="'.$this->data['id'].'" and id="'.$requirement['id'].'"');
      if ($db->affected_rows()==-1) $ok=0;
     }
   }
   else
   {
    $this->components[$entry['component']]['value']+=$entry['quantity'];
    $db->query('update components set value="'.$this->components[$entry['component']]['value'].'" where node="'.$this->data['id'].'" and id="'.$entry['component'].'"');
    if ($db->affected_rows()==-1) $ok=0;
   }
   $this->getQueue('craft', 'component', $game['modules'][$this->data['faction']][$moduleId]['components']);
   $entry['duration']=floor($entry['duration']*60);
   foreach ($this->queue['craft'] as $queueEntry)
   {
    if ($queueEntry['start']>$entry['start'])
    {
     $db->query('update craft set start="'.strftime('%Y-%m-%d %H:%M:%S', $queueEntry['start']-$entry['duration']).'" where id="'.$queueEntry['id'].'"');
     if ($db->affected_rows()==-1) $ok=0;
    }
   }
   $db->query('delete from craft where id="'.$craftId.'"');
   if ($db->affected_rows()==-1) $ok=0;
   if ($ok) $status='done';
   else $status='error';
  }
  else $status='noEntry';
  return $status;
 }
 public function addUnit($unitId, $quantity, $slotId)
 {
  global $db, $game;
  $this->getModules();
  $this->getResources();
  $this->getTechnologies();
  $this->getComponents();
  $this->getUnits();
  $unit=array();
  if (isset($this->units[$unitId]))
  {
   $okModule=0;
   if (isset($this->modules[$slotId]['module']))
    if (in_array($unitId, $game['modules'][$this->data['faction']][$this->modules[$slotId]['module']]['units']))
     $okModule=1;
   if ($okModule)
   {
    $unit['requirementsData']=$this->checkRequirements($game['units'][$this->data['faction']][$unitId]['requirements'], $quantity);
    if ($unit['requirementsData']['ok'])
     if ($this->resources[$game['units'][$this->data['faction']][$unitId]['upkeepResource']]['value']>=$game['units'][$this->data['faction']][$unitId]['upkeep']*$quantity)
     {
      $unit['costData']=$this->checkCost($game['units'][$this->data['faction']][$unitId]['cost'], 'train', $quantity);
      if ($unit['costData']['ok'])
      {
       $ok=1;
       $upkeepResource=$game['units'][$this->data['faction']][$unitId]['upkeepResource'];
       $this->resources[$upkeepResource]['value']-=$game['units'][$this->data['faction']][$unitId]['upkeep']*$quantity;
       $db->query('update resources set value="'.$this->resources[$upkeepResource]['value'].'" where node="'.$this->data['id'].'" and id="'.$upkeepResource.'"');
       if ($db->affected_rows()==-1) $ok=0;
       foreach ($game['units'][$this->data['faction']][$unitId]['cost'] as $cost)
       {
        $this->resources[$cost['resource']]['value']-=$cost['value']*$quantity*$game['users']['cost']['train'];
        $db->query('update resources set value="'.$this->resources[$cost['resource']]['value'].'" where node="'.$this->data['id'].'" and id="'.$cost['resource'].'"');
        if ($db->affected_rows()==-1) $ok=0;
       }
       foreach ($game['units'][$this->data['faction']][$unitId]['requirements'] as $requirement)
        if ($requirement['type']=='components')
        {
         $storageResource=$game['components'][$this->data['faction']][$requirement['id']]['storageResource'];
         $this->resources[$storageResource]['value']+=$game['components'][$this->data['faction']][$requirement['id']]['storage']*$quantity;
         $db->query('update resources set value="'.$this->resources[$storageResource]['value'].'" where node="'.$this->data['id'].'" and id="'.$storageResource.'"');
         if ($db->affected_rows()==-1) $ok=0;
         $this->components[$requirement['id']]['value']-=$requirement['value']*$quantity;
         $db->query('update components set value="'.$this->components[$requirement['id']]['value'].'" where node="'.$this->data['id'].'" and id="'.$requirement['id'].'"');
         if ($db->affected_rows()==-1) $ok=0;
        }
       $this->getQueue('train', 'unit', $game['modules'][$this->data['faction']][$this->modules[$slotId]['module']]['units']);
       $lastTrain=count($this->queue['train'])-1;
       if ($lastTrain>-1) $start=strftime('%Y-%m-%d %H:%M:%S', $this->queue['train'][$lastTrain]['start']+floor($this->queue['train'][$lastTrain]['duration']*60));
       else $start=strftime('%Y-%m-%d %H:%M:%S', time());
       $totalIR=0;
       foreach ($this->modules as $key=>$item)
        if ($item['module']==$this->modules[$slotId]['module']) $totalIR+=$item['input']*$game['modules'][$this->data['faction']][$item['module']]['ratio'];
       $duration=$game['units'][$this->data['faction']][$unitId]['duration']*$quantity;
       $duration=($duration-$duration*$totalIR)*$game['users']['speed']['train'];
       $result=$db->query('select max(id) as id from train where node="'.$this->data['id'].'"');
       $row=db::fetch($result);
       $id=$row['id']+1;
       $db->query('insert into train (id, node, unit, quantity, stage, start, duration) values ("'.$id.'", "'.$this->data['id'].'", "'.$unitId.'", "'.$quantity.'", 0, "'.$start.'", "'.$duration.'")');
       if ($db->affected_rows()==-1) $ok=0;
       if ($ok) $status='done';
       else $status='error';
      }
      else $status='notEnoughResources';
     }
     else $status='notEnoughUpkeepResource';
    else $status='requirementsNotMet';
   }
   else $status='requirementsNotMet';
  }
  else $status='noUnit';
  return $status;
 }
 public function removeUnit($unitId, $quantity, $moduleId)
 {
  global $db, $game;
  $this->getModules();
  $this->getResources();
  $this->getComponents();
  $this->getUnits();
  $unit=array();
  if (isset($this->units[$unitId]))
   if ($this->units[$unitId]['value']>=$quantity)
   {
    $ok=1;
    $upkeepResource=$game['units'][$this->data['faction']][$unitId]['upkeepResource'];
    $this->resources[$upkeepResource]['value']+=$game['units'][$this->data['faction']][$unitId]['upkeep']*$quantity;
    $db->query('update resources set value="'.$this->resources[$upkeepResource]['value'].'" where node="'.$this->data['id'].'" and id="'.$upkeepResource.'"');
    if ($db->affected_rows()==-1) $ok=0;
    $this->units[$unitId]['value']-=$quantity;
    $db->query('update units set value="'.$this->units[$unitId]['value'].'" where node="'.$this->data['id'].'" and id="'.$unitId.'"');
    if ($db->affected_rows()==-1) $ok=0;
    $this->getQueue('train', 'unit', $game['modules'][$this->data['faction']][$moduleId]['units']);
    $lastTrain=count($this->queue['train'])-1;
    if ($lastTrain>-1) $start=strftime('%Y-%m-%d %H:%M:%S', $this->queue['train'][$lastTrain]['start']+floor($this->queue['train'][$lastTrain]['duration']*60));
    else $start=strftime('%Y-%m-%d %H:%M:%S', time());
    $totalIR=0;
    foreach ($this->modules as $key=>$item)
     if ($item['module']==$moduleId) $totalIR+=$item['input']*$game['modules'][$this->data['faction']][$item['module']]['ratio'];
    $duration=$game['units'][$this->data['faction']][$unitId]['removeDuration']*$quantity;
    $duration=($duration-$duration*$totalIR)*$game['users']['speed']['train'];
    $result=$db->query('select max(id) as id from train where node="'.$this->data['id'].'"');
    $row=db::fetch($result);
    $id=$row['id']+1;
    $db->query('insert into train (id, node, unit, quantity, stage, start, duration) values ("'.$id.'", "'.$this->data['id'].'", "'.$unitId.'", "'.$quantity.'", 1, "'.$start.'", "'.$duration.'")');
    if ($db->affected_rows()==-1) $ok=0;
    if ($ok) $status='done';
    else $status='error';
   }
   else $status='notEnoughUnits';
  else $status='noUnit';
  return $status;
 }
 public function cancelUnit($trainId, $moduleId)
 {
  global $db, $game;
  $this->getResources();
  $this->getComponents();
  $this->getUnits();
  $result=$db->query('select * from train where id="'.$trainId.'"');
  $entry=db::fetch($result);
  if (isset($entry['start']))
  {
   $entry['start']=strtotime($entry['start']);
   $ok=1;
   $upkeepResource=$game['units'][$this->data['faction']][$entry['unit']]['upkeepResource'];
   $upkeep=$game['units'][$this->data['faction']][$entry['unit']]['upkeep']*$entry['quantity'];
   if (!$entry['stage']) $this->resources[$upkeepResource]['value']+=$upkeep;
   else $this->resources[$upkeepResource]['value']-=$upkeep;
   $db->query('update resources set value="'.$this->resources[$upkeepResource]['value'].'" where node="'.$this->data['id'].'" and id="'.$upkeepResource.'"');
   if ($db->affected_rows()==-1) $ok=0;
   if (!$entry['stage'])
   {
    foreach ($game['units'][$this->data['faction']][$entry['unit']]['cost'] as $cost)
    {
     $this->resources[$cost['resource']]['value']+=$cost['value']*$entry['quantity']*$game['users']['cost']['train'];
     $db->query('update resources set value="'.$this->resources[$cost['resource']]['value'].'" where node="'.$this->data['id'].'" and id="'.$cost['resource'].'"');
     if ($db->affected_rows()==-1) $ok=0;
    }
    foreach ($game['units'][$this->data['faction']][$entry['unit']]['requirements'] as $requirement)
     if ($requirement['type']=='components')
     {
      $storageResource=$game['components'][$this->data['faction']][$requirement['id']]['storageResource'];
      $this->resources[$storageResource]['value']-=$game['components'][$this->data['faction']][$requirement['id']]['storage']*$entry['quantity'];
      $db->query('update resources set value="'.$this->resources[$storageResource]['value'].'" where node="'.$this->data['id'].'" and id="'.$storageResource.'"');
      if ($db->affected_rows()==-1) $ok=0;
      $this->components[$requirement['id']]['value']+=$requirement['value']*$entry['quantity'];
      $db->query('update components set value="'.$this->components[$requirement['id']]['value'].'" where node="'.$this->data['id'].'" and id="'.$requirement['id'].'"');
      if ($db->affected_rows()==-1) $ok=0;
     }
   }
   else
   {
    $this->units[$entry['unit']]['value']+=$entry['quantity'];
    $db->query('update units set value="'.$this->units[$entry['unit']]['value'].'" where node="'.$this->data['id'].'" and id="'.$entry['unit'].'"');
    if ($db->affected_rows()==-1) $ok=0;
   }
   $this->getQueue('train', 'unit', $game['modules'][$this->data['faction']][$moduleId]['units']);
   $entry['duration']=floor($entry['duration']*60);
   foreach ($this->queue['train'] as $queueEntry)
   {
    if ($queueEntry['start']>$entry['start'])
    {
     $db->query('update train set start="'.strftime('%Y-%m-%d %H:%M:%S', $queueEntry['start']-$entry['duration']).'" where id="'.$queueEntry['id'].'"');
     if ($db->affected_rows()==-1) $ok=0;
    }
   }
   $db->query('delete from train where id="'.$trainId.'"');
   if ($db->affected_rows()==-1) $ok=0;
   if ($ok) $status='done';
   else $status='error';
  }
  else $status='noEntry';
  return $status;
 }
 public static function getCombat($combatId)
 {
  global $db, $game;
  $result=$db->query('select * from combat where id="'.$combatId.'"');
  $combat=db::fetch($result);
  return $combat;
 }
 public function addCombat($nodeId, $data)
 {
  global $db, $game;
  $this->getResources();
  $this->getUnits();
  $this->getLocation();
  $node=new node();
  $okUnits=1;
  $army=array();
  foreach ($data['input']['attacker']['groups'] as $group)
   if (isset($army[$group['unitId']])) $army[$group['unitId']]+=$group['quantity'];
   else $army[$group['unitId']]=$group['quantity'];
  $speed=999999999;
  foreach ($this->units as $key=>$group)
   if (isset($army[$key]))
   {
    if ($army[$key]>$group['value']) $okUnits=0;
    if ($game['units'][$this->data['faction']][$key]['speed']<$speed) $speed=$game['units'][$this->data['faction']][$key]['speed'];
   }
  $combatCost=$game['factions'][$this->data['id']]['costs']['combat'];
  $okCombatCost=$this->checkCost($combatCost, 'combat');
  if ($okUnits)
   if ($okCombatCost['ok'])
    if ($node->get('id', $nodeId)=='done')
    {
     $node->getLocation();
     $distance=sqrt(pow(abs($this->location['x']-$node->location['x']), 2)+pow(abs($this->location['y']-$node->location['y']), 2));
     $duration=$distance/($speed*$game['users']['speed']['combat']);
     $combatId=misc::newId('combat');
     $ok=1;
     $cuBuffer=array();
     foreach ($army as $key=>$value)
     {
      $cuBuffer[]='("'.$combatId.'", "'.$key.'", "'.$value.'")';
      $this->units[$key]['value']-=$value;
      $db->query('update units set value="'.$this->units[$key]['value'].'" where node="'.$this->data['id'].'" and id="'.$key.'"');
      if ($db->affected_rows()==-1) $ok=0;
      $upkeepResource=$game['units'][$this->data['faction']][$key]['upkeepResource'];
      $upkeep=$game['units'][$this->data['faction']][$key]['upkeep'];
      $this->resources[$upkeepResource]['value']+=$upkeep*$value;
      $db->query('update resources set value="'.$this->resources[$upkeepResource]['value'].'" where node="'.$this->data['id'].'" and id="'.$upkeepResource.'"');
      if ($db->affected_rows()==-1) $ok=0;
     }
     foreach ($combatCost as $cost)
     {
      $this->resources[$cost['resource']]['value']-=$cost['value']*$game['users']['cost']['combat'];
      $db->query('update resources set value="'.$this->resources[$cost['resource']]['value'].'" where node="'.$this->data['id'].'" and id="'.$cost['resource'].'"');
      if ($db->affected_rows()==-1) $ok=0;
     }
     $db->query('insert into combat (id, sender, recipient, focus, stage, start, duration) values ("'.$combatId.'", "'.$this->data['id'].'", "'.$node->data['id'].'", "'.$data['input']['attacker']['focus'].'", "0", "'.strftime('%Y-%m-%d %H:%M:%S', time()).'", "'.$duration.'")');
     if ($db->affected_rows()==-1) $ok=0;
     $db->query('insert into combat_units (combat, id, value) values '.implode(', ', $cuBuffer));
     if ($db->affected_rows()==-1) $ok=0;
     if ($ok) $status='done';
     else $status='error';
    }
    else $status='noNode';
   else $status='notEnoughResources';
  else $status='notEnoughUnits';
  return $status;
 }
 public function cancelCombat($combatId)
 {
  global $db, $game;
  $result=$db->query('select * from combat where stage=0 and id="'.$combatId.'"');
  $row=db::fetch($result);
  if (isset($row['id']))
  {
   $elapsed=(time()-strtotime($row['start']))/60;
   $start=strftime('%Y-%m-%d %H:%M:%S', time());
   $db->query('update combat set stage=1, start="'.$start.'", duration="'.$elapsed.'" where id="'.$combatId.'"');
   if ($db->affected_rows()==-1) $status='error';
   else $status='done';
  }
  else $status='noCombat';
  return $status;
 }
 public function checkResources($time)
 {
  global $db, $game;
  $db->query('start transaction');
  $this->getModules();
  $this->getResources();
  $elapsed=($time-strtotime($this->data['lastCheck']))/3600;
  $ok=1;
  foreach ($game['resources'] as $key=>$resource)
   if ($resource['type']=='dynamic')
   {
    $this->resources[$key]['value']+=$this->production[$key]*$elapsed;
    if ($this->storage[$key])
     if ($this->resources[$key]['value']>$this->storage[$key])
      $this->resources[$key]['value']=$this->storage[$key];
    $db->query('update resources set value="'.$this->resources[$key]['value'].'" where node="'.$this->data['id'].'" and id="'.$key.'"');
    if ($db->affected_rows()==-1) $ok=0;
    $db->query('update nodes set lastCheck="'.strftime('%Y-%m-%d %H:%M:%S', $time).'" where id="'.$this->data['id'].'"');
    if ($db->affected_rows()==-1) $ok=0;
   }
  if ($ok) $db->query('commit');
  else $db->query('rollback');
 }
 public function checkResearch($time)
 {
  global $db, $game;
  $db->query('start transaction');
  $this->getTechnologies();
  $this->getQueue('research');
  $ok=1;
  foreach ($this->queue['research'] as $entry)
  {
   $entry['end']=$entry['start']+floor($entry['duration']*60);
   if ($entry['end']<=$time)
   {
    $this->technologies[$entry['technology']]['value']++;
    $db->query('update technologies set value="'.$this->technologies[$entry['technology']]['value'].'" where node="'.$this->data['id'].'" and id="'.$entry['technology'].'"');
    if ($db->affected_rows()==-1) $ok=0;
    $db->query('delete from research where node="'.$this->data['id'].'" and technology="'.$entry['technology'].'"');
    if ($db->affected_rows()==-1) $ok=0;
   }
  }
  if ($ok) $db->query('commit');
  else $db->query('rollback');
 }
 public function checkBuild($time)
 {
  global $db, $game;
  $db->query('start transaction');
  $this->getModules();
  $this->getResources();
  $this->getComponents();
  $this->getQueue('build');
  $ok=1;
  foreach ($this->queue['build'] as $entry)
  {
   $entry['end']=$entry['start']+floor($entry['duration']*60);
   if ($entry['end']<=$time)
   {
    if ($this->modules[$entry['slot']]['module']==-1)//build module
    {
     $this->modules[$entry['slot']]['module']=$entry['module'];
     $db->query('update modules set module="'.$entry['module'].'" where node="'.$this->data['id'].'" and slot="'.$entry['slot'].'"');
     if ($db->affected_rows()==-1) $ok=0;
    }
    else//remove module
    {
     foreach ($game['modules'][$this->data['faction']][$entry['module']]['cost'] as $cost)
     {
      $this->resources[$cost['resource']]['value']+=$cost['value']*$game['users']['cost']['build']*$game['modules'][$this->data['faction']][$entry['module']]['salvage'];
      $db->query('update resources set value="'.$this->resources[$cost['resource']]['value'].'" where node="'.$this->data['id'].'" and id="'.$cost['resource'].'"');
      if ($db->affected_rows()==-1) $ok=0;
     }
     foreach ($game['modules'][$this->data['faction']][$entry['module']]['requirements'] as $requirement)
      if ($requirement['type']=='components')
      {
       $storageResource=$game['components'][$this->data['faction']][$requirement['id']]['storageResource'];
       $storage=$game['components'][$this->data['faction']][$requirement['id']]['storage']*$requirement['value'];
       if ($this->resources[$storageResource]['value']-$storage>=0)
       {
        $this->resources[$storageResource]['value']-=$storage;
        $db->query('update resources set value="'.$this->resources[$storageResource]['value'].'" where node="'.$this->data['id'].'" and id="'.$storageResource.'"');
        if ($db->affected_rows()==-1) $ok=0;
        $this->components[$requirement['id']]['value']+=$requirement['value'];
        $db->query('update components set value="'.$this->components[$requirement['id']]['value'].'" where node="'.$this->data['id'].'" and id="'.$requirement['id'].'"');
        if ($db->affected_rows()==-1) $ok=0;
       }
      }
     if ($this->modules[$entry['slot']]['input']>0)
     {
      $inputResource=$game['modules'][$this->data['faction']][$entry['module']]['inputResource'];
      $this->resources[$inputResource]['value']+=$this->modules[$entry['slot']]['input'];
      $db->query('update resources set value="'.$this->resources[$inputResource]['value'].'" where node="'.$this->data['id'].'" and id="'.$inputResource.'"');
      if ($db->affected_rows()==-1) $ok=0;
     }
     $this->modules[$entry['slot']]['module']=-1;
     $this->checkModuleDependencies($entry['module'], $entry['slot']);
     $db->query('update modules set module="-1", input="0" where node="'.$this->data['id'].'" and slot="'.$entry['slot'].'"');
     if ($db->affected_rows()==-1) $ok=0;
    }
    $db->query('delete from build where node="'.$this->data['id'].'" and slot="'.$entry['slot'].'"');
    if ($db->affected_rows()==-1) $ok=0;
   }
  }
  if ($ok) $db->query('commit');
  else $db->query('rollback');
 }
 public function checkCraft($time)
 {
  global $db, $game;
  $db->query('start transaction');
  $this->getResources();
  $this->getComponents();
  $this->getQueue('craft');
  $ok=1;
  foreach ($this->queue['craft'] as $entry)
  {
   $entry['end']=$entry['start']+floor($entry['duration']*60);
   if ($entry['end']<=$time)
   {
    if (!$entry['stage'])
    {
     $this->components[$entry['component']]['value']+=$entry['quantity'];
     $db->query('update components set value="'.$this->components[$entry['component']]['value'].'" where node="'.$this->data['id'].'" and id="'.$entry['component'].'"');
     if ($db->affected_rows()==-1) $ok=0;
    }
    else
    {
     foreach ($game['components'][$this->data['faction']][$entry['component']]['cost'] as $cost)
     {
      $this->resources[$cost['resource']]['value']+=$cost['value']*$entry['quantity']*$game['users']['cost']['craft']*$game['components'][$this->data['faction']][$entry['component']]['salvage'];
      $db->query('update resources set value="'.$this->resources[$cost['resource']]['value'].'" where node="'.$this->data['id'].'" and id="'.$cost['resource'].'"');
      if ($db->affected_rows()==-1) $ok=0;
     }
     foreach ($game['components'][$this->data['faction']][$entry['component']]['requirements'] as $requirement)
      if ($requirement['type']=='components')
      {
       $storageResource=$game['components'][$this->data['faction']][$requirement['id']]['storageResource'];
       $storage=$game['components'][$this->data['faction']][$requirement['id']]['storage']*$requirement['value']*$entry['quantity'];
       if ($this->resources[$storageResource]['value']-$storage>=0)
       {
        $this->resources[$storageResource]['value']-=$storage;
        $db->query('update resources set value="'.$this->resources[$storageResource]['value'].'" where node="'.$this->data['id'].'" and id="'.$storageResource.'"');
        if ($db->affected_rows()==-1) $ok=0;
        $this->components[$requirement['id']]['value']+=$requirement['value']*$entry['quantity'];
        $db->query('update components set value="'.$this->components[$requirement['id']]['value'].'" where node="'.$this->data['id'].'" and id="'.$requirement['id'].'"');
        if ($db->affected_rows()==-1) $ok=0;
       }
      }
    }
    $db->query('delete from craft where id="'.$entry['id'].'"');
    if ($db->affected_rows()==-1) $ok=0;
   }
  }
  if ($ok) $db->query('commit');
  else $db->query('rollback');
 }
 public function checkTrain($time)
 {
  global $db, $game;
  $db->query('start transaction');
  $this->getResources();
  $this->getComponents();
  $this->getUnits();
  $this->getQueue('train');
  $ok=1;
  foreach ($this->queue['train'] as $entry)
  {
   $entry['end']=$entry['start']+floor($entry['duration']*60);
   if ($entry['end']<=$time)
   {
    if (!$entry['stage'])
    {
     $this->units[$entry['unit']]['value']+=$entry['quantity'];
     $db->query('update units set value="'.$this->units[$entry['unit']]['value'].'" where node="'.$this->data['id'].'" and id="'.$entry['unit'].'"');
     if ($db->affected_rows()==-1) $ok=0;
    }
    else
    {
     foreach ($game['units'][$this->data['faction']][$entry['unit']]['cost'] as $cost)
     {
      $this->resources[$cost['resource']]['value']+=$cost['value']*$entry['quantity']*$game['users']['cost']['train']*$game['units'][$this->data['faction']][$entry['unit']]['salvage'];
      $db->query('update resources set value="'.$this->resources[$cost['resource']]['value'].'" where node="'.$this->data['id'].'" and id="'.$cost['resource'].'"');
      if ($db->affected_rows()==-1) $ok=0;
     }
     foreach ($game['units'][$this->data['faction']][$entry['unit']]['requirements'] as $requirement)
      if ($requirement['type']=='components')
      {
       $storageResource=$game['components'][$this->data['faction']][$requirement['id']]['storageResource'];
       $storage=$game['components'][$this->data['faction']][$requirement['id']]['storage']*$requirement['value']*$entry['quantity'];
       if ($this->resources[$storageResource]['value']-$storage>=0)
       {
        $this->resources[$storageResource]['value']-=$storage;
        $db->query('update resources set value="'.$this->resources[$storageResource]['value'].'" where node="'.$this->data['id'].'" and id="'.$storageResource.'"');
        if ($db->affected_rows()==-1) $ok=0;
        $this->components[$requirement['id']]['value']+=$requirement['value']*$entry['quantity'];
        $db->query('update components set value="'.$this->components[$requirement['id']]['value'].'" where node="'.$this->data['id'].'" and id="'.$requirement['id'].'"');
        if ($db->affected_rows()==-1) $ok=0;
       }
      }
    }
    $db->query('delete from train where id="'.$entry['id'].'"');
    if ($db->affected_rows()==-1) $ok=0;
   }
  }
  if ($ok) $db->query('commit');
  else $db->query('rollback');
 }
 public function checkCombat($time)
 {
  global $db, $game, $ui;
  $db->query('start transaction');
  $this->getQueue('combat');
  $ok=1;
  foreach ($this->queue['combat'] as $combat)
  {
   $combat['end']=$combat['start']+floor($combat['duration']*60);
   if ($combat['end']<=$time)
   {
    $otherNode=new node();
    if ($combat['sender']==$this->data['id'])
    {
     $nodes=array('attacker'=>'this', 'defender'=>'otherNode');
     $status=$otherNode->get('id', $combat['recipient']);
    }
    else
    {
     $nodes=array('attacker'=>'otherNode', 'defender'=>'this');
     $status=$otherNode->get('id', $combat['sender']);
    }
    if (!$combat['stage'])
    {
     if ($status=='done')
     {
      $data=array();
      $data['input']['attacker']['focus']=$combat['focus'];
      $data['input']['attacker']['faction']=$$nodes['attacker']->data['faction'];
      $otherResult=$db->query('select * from combat_units where combat="'.$combat['id'].'"');
      while ($group=db::fetch($otherResult))
       $data['input']['attacker']['groups'][]=array('unitId'=>$group['id'], 'quantity'=>$group['value']);
      $data['input']['defender']['focus']=$$nodes['defender']->data['focus'];
      $data['input']['defender']['faction']=$$nodes['defender']->data['faction'];
      $otherNode->getUnits();
      foreach ($$nodes['defender']->units as $group)
       $data['input']['defender']['groups'][]=array('unitId'=>$group['id'], 'quantity'=>$group['value']);
      $data=node::doCombat($data);
      $captureNode=true;
      $$nodes['defender']->getResources();
      foreach ($data['output']['defender']['groups'] as $key=>$group)
      {
       $db->query('update units set value="'.$group['quantity'].'" where node="'.$$nodes['defender']->data['id'].'" and id="'.$group['unitId'].'"');
       if ($db->affected_rows()==-1) $ok=0;
       $lostCount=$data['input']['defender']['groups'][$key]['quantity']-$group['quantity'];
       if ($lostCount>0)
       {
        $upkeepResource=$game['units'][$$nodes['defender']->data['faction']][$group['unitId']]['upkeepResource'];
        $upkeep=$game['units'][$$nodes['defender']->data['faction']][$group['unitId']]['upkeep'];
        $$nodes['defender']->resources[$upkeepResource]['value']+=$upkeep*$lostCount;
        $db->query('update resources set value="'.$$nodes['defender']->resources[$upkeepResource]['value'].'" where node="'.$$nodes['defender']->data['id'].'" and id="'.$upkeepResource.'"');
        if ($db->affected_rows()==-1) $ok=0;
       }
       if ($group['quantity']) $captureNode=false;
      }
      foreach ($data['output']['attacker']['groups'] as $key=>$group)
      {
       $db->query('update combat_units set value="'.$group['quantity'].'" where combat="'.$combat['id'].'" and id="'.$group['unitId'].'"');
       if ($db->affected_rows()==-1) $ok=0;
      }
      $start=strftime('%Y-%m-%d %H:%M:%S', $combat['end']);
      $db->query('update combat set stage=1, start="'.$start.'" where id="'.$combat['id'].'"');
      if ($db->affected_rows()==-1) $ok=0;
      if ($captureNode)
      {
       $db->query('update nodes set user="'.$$nodes['attacker']->data['user'].'" where id="'.$$nodes['defender']->data['id'].'"');
       if ($db->affected_rows()==-1) $ok=0;
      }
      //send reports; to be ported to an addon (remember to remove global "$ui")
      if ($data['output']['attacker']['winner']) $attackerOutcome=$ui['won'];
      else $attackerOutcome=$ui['lost'];
      if ($data['output']['defender']['winner']) $defenderOutcome=$ui['won'];
      else $defenderOutcome=$ui['lost'];
      $msgBody='<div style="text-align: center;">';
      foreach ($data['output']['attacker']['groups'] as $key=>$group)
       $msgBody.='<div class="cell"><div class="unitBlock"><img class="unitBlock" src="templates/default/images/units/'.$$nodes['attacker']->data['faction'].'/'.$group['unitId'].'.png"></div><div class="unitBlock">'.$data['input']['attacker']['groups'][$key]['quantity'].'</div><div class="unitBlock">'.$group['quantity'].'</div></div>';
      $msgBody.='</div><div style="text-align: center;">'.$attackerOutcome.'</div><div style="text-align: center;">-----</div><div style="text-align: center;">'.$defenderOutcome.'</div><div style="text-align: center;">';
      foreach ($data['output']['defender']['groups'] as $key=>$group)
       if ($data['input']['defender']['groups'][$key]['quantity']) $msgBody.='<div class="cell"><div class="unitBlock">'.$group['quantity'].'</div><div class="unitBlock">'.$data['input']['defender']['groups'][$key]['quantity'].'</div><div class="unitBlock"><img class="unitBlock" src="templates/default/images/units/'.$$nodes['defender']->data['faction'].'/'.$group['unitId'].'.png"></div></div>';
      $msgBody.='</div>';
      $msgBody=$db->real_escape_string($msgBody);
      $attackerUser=new user();
      if ($attackerUser->get('id', $$nodes['attacker']->data['user'])=='done')
      {
       $attackerUser->getPreferences('name');
       if ($attackerUser->preferences['combatReports'])
       {
        $msg=new message();
        $msg->data['sender']=$attackerUser->data['name'];
        $msg->data['recipient']=$attackerUser->data['name'];
        $msg->data['subject']=$ui['combatReport'].' - '.$$nodes['defender']->data['name'];
        $msg->data['body']=$msgBody;
        $msg->data['viewed']=0;
        $msg->add();
       }
      }
      $defenderUser=new user();
      if ($defenderUser->get('id', $$nodes['defender']->data['user'])=='done')
      {
       $defenderUser->getPreferences('name');
       if ($defenderUser->preferences['combatReports'])
       {
        $msg=new message();
        $msg->data['sender']=$defenderUser->data['name'];
        $msg->data['recipient']=$defenderUser->data['name'];
        $msg->data['subject']=$ui['combatReport'].' - '.$$nodes['defender']->data['name'];
        $msg->data['body']=$msgBody;
        $msg->data['viewed']=0;
        $msg->add();
       }
      }
      //\send reports
     }
    }
    else
    {
     $$nodes['attacker']->getResources();
     $result=$db->query('select * from combat_units where combat="'.$combat['id'].'"');
     while ($group=db::fetch($result))
     {
      $db->query('update units set value="'.$group['value'].'" where node="'.$combat['sender'].'" and id="'.$group['id'].'"');
      if ($db->affected_rows()==-1) $ok=0;
      $upkeepResource=$game['units'][$$nodes['attacker']->data['faction']][$group['id']]['upkeepResource'];
      $upkeep=$game['units'][$$nodes['attacker']->data['faction']][$group['id']]['upkeep'];
      $this->resources[$upkeepResource]['value']-=$upkeep*$group['value'];
      $db->query('update resources set value="'.$$nodes['attacker']->resources[$upkeepResource]['value'].'" where node="'.$$nodes['attacker']->data['id'].'" and id="'.$upkeepResource.'"');
      if ($db->affected_rows()==-1) $ok=0;
     }
     $db->query('delete from combat_units where combat="'.$combat['id'].'"');
     if ($db->affected_rows()==-1) $ok=0;
     $db->query('delete from combat where id="'.$combat['id'].'"');
     if ($db->affected_rows()==-1) $ok=0;
    }
   }
  }
  if ($ok) $db->query('commit');
  else $db->query('rollback');
 }
 public function checkAll($time)
 {
  $this->checkResources($time);
  $this->checkResearch($time);
  $this->checkBuild($time);
  $this->checkCraft($time);
  $this->checkTrain($time);
  //$this->checkTrade($time);
  $this->checkCombat($time);
 }
 public function checkRequirements($requirements, $quantity=1)
 {
  $data=array('ok'=>1, 'requirements'=>$requirements);
  foreach ($data['requirements'] as $key=>$requirement)
   if ($requirement['value'])
    switch ($requirement['type'])
    {
     case 'technologies':
      if ($this->technologies[$requirement['id']]['value']<$requirement['value'])
      {
       $data['requirements'][$key]['ok']=0;
       $data['ok']=0;
      }
      else $data['requirements'][$key]['ok']=1;
     break;
     case 'modules':
      $moduleCount=0;
      foreach ($this->modules as $module)
       if ($module['module']==$requirement['id']) $moduleCount++;
      if ($moduleCount<$requirement['value'])
      {
       $data['requirements'][$key]['ok']=0;
       $data['ok']=0;
      }
      else $data['requirements'][$key]['ok']=1;
     break;
     case 'components':
      if ($this->components[$requirement['id']]['value']<$requirement['value']*$quantity)
      {
       $data['requirements'][$key]['ok']=0;
       $data['ok']=0;
      }
      else $data['requirements'][$key]['ok']=1;
     break;
    }
   else $data['requirements'][$key]['ok']=1;
  return $data;
 }
 public function checkCost($cost, $costType, $quantity=1)
 {
  global $game;
  $data=array('ok'=>1, 'cost'=>$cost);
  foreach ($data['cost'] as $key=>$cost)
   if ($this->resources[$cost['resource']]['value']<$cost['value']*$quantity*$game['users']['cost'][$costType])
   {
    $data['cost'][$key]['ok']=0;
    $data['ok']=0;
   }
   else $data['cost'][$key]['ok']=1;
  return $data;
 }
 private function checkModuleDependencies($moduleId, $slotId, $useOldIR=0)
 {
  global $db, $game;
  switch ($game['modules'][$this->data['faction']][$moduleId]['type'])
  {
   case 'research':
    $this->getQueue('research', 'technology', $game['modules'][$this->data['faction']][$moduleId]['technologies']);
    $nr=count($this->queue['research']);
    if ($nr)
    {
     $newIR=$oldIR=0;
     $moduleCount=0;
     foreach ($this->modules as $key=>$module)
      if ($module['module']==$moduleId)
      {
       if ($module['slot']!=$slotId) $newIR+=$module['input']*$game['modules'][$this->data['faction']][$module['module']]['ratio'];
       $oldIR+=$module['input']*$game['modules'][$this->data['faction']][$module['module']]['ratio'];
       $moduleCount++;
      }
     if ($useOldIR) $newIR=$oldIR;
     for ($i=0; $i<$nr; $i++)
     {
      if ($i) $this->queue['research'][$i]['start']=$this->queue['research'][$i-1]['start']+floor($this->queue['research'][$i-1]['duration']*60);
      $this->queue['research'][$i]['duration']=$game['technologies'][$this->data['faction']][$this->queue['research'][$i]['technology']]['duration'];
      $this->queue['research'][$i]['duration']=($this->queue['research'][$i]['duration']-$this->queue['research'][$i]['duration']*$newIR)*$game['users']['speed']['research'];
      $db->query('update research set start="'.strftime('%Y-%m-%d %H:%M:%S', $this->queue['research'][$i]['start']).'", duration="'.$this->queue['research'][$i]['duration'].'" where node="'.$this->queue['research'][$i]['node'].'" and technology="'.$this->queue['research'][$i]['technology'].'"');
      if (!$moduleCount) $this->cancelTechnology($this->queue['research'][$i]['technology'], $moduleId);
     }
    }
   break;
   case 'craft':
    $this->getQueue('craft', 'component', $game['modules'][$this->data['faction']][$moduleId]['components']);
    $nr=count($this->queue['craft']);
    if ($nr)
    {
     $newIR=$oldIR=0;
     $moduleCount=0;
     foreach ($this->modules as $key=>$module)
      if ($module['module']==$moduleId)
      {
       if ($module['slot']!=$slotId) $newIR+=$module['input']*$game['modules'][$this->data['faction']][$module['module']]['ratio'];
       $oldIR+=$module['input']*$game['modules'][$this->data['faction']][$module['module']]['ratio'];
       $moduleCount++;
      }
     if ($useOldIR) $newIR=$oldIR;
     for ($i=0; $i<$nr; $i++)
     {
      if ($i) $this->queue['craft'][$i]['start']=$this->queue['craft'][$i-1]['start']+floor($this->queue['craft'][$i-1]['duration']*60);
      $this->queue['craft'][$i]['duration']=$game['components'][$this->data['faction']][$this->queue['craft'][$i]['component']]['duration']*$this->queue['craft'][$i]['quantity'];
      $this->queue['craft'][$i]['duration']=($this->queue['craft'][$i]['duration']-$this->queue['craft'][$i]['duration']*$newIR)*$game['users']['speed']['craft'];
      $db->query('update craft set start="'.strftime('%Y-%m-%d %H:%M:%S', $this->queue['craft'][$i]['start']).'", duration="'.$this->queue['craft'][$i]['duration'].'" where id="'.$this->queue['craft'][$i]['id'].'"');
      if (!$moduleCount) $this->cancelComponent($this->queue['craft'][$i]['id'], $moduleId);
     }
    }
   break;
   case 'train':
    $this->getQueue('train', 'unit', $game['modules'][$this->data['faction']][$moduleId]['units']);
    $nr=count($this->queue['train']);
    if ($nr)
    {
     $newIR=$oldIR=0;
     $moduleCount=0;
     foreach ($this->modules as $key=>$module)
      if ($module['module']==$moduleId)
      {
       if ($module['slot']!=$slotId) $newIR+=$module['input']*$game['modules'][$this->data['faction']][$module['module']]['ratio'];
       $oldIR+=$module['input']*$game['modules'][$this->data['faction']][$module['module']]['ratio'];
       $moduleCount++;
      }
     if ($useOldIR) $newIR=$oldIR;
     for ($i=0; $i<$nr; $i++)
     {
      if ($i) $this->queue['train'][$i]['start']=$this->queue['train'][$i-1]['start']+floor($this->queue['train'][$i-1]['duration']*60);
      $this->queue['train'][$i]['duration']=$game['units'][$this->data['faction']][$this->queue['train'][$i]['unit']]['duration']*$this->queue['train'][$i]['quantity'];
      $this->queue['train'][$i]['duration']=($this->queue['train'][$i]['duration']-$this->queue['train'][$i]['duration']*$newIR)*$game['users']['speed']['train'];
      $db->query('update train set start="'.strftime('%Y-%m-%d %H:%M:%S', $this->queue['train'][$i]['start']).'", duration="'.$this->queue['train'][$i]['duration'].'" where id="'.$this->queue['train'][$i]['id'].'"');
      if (!$moduleCount) $this->cancelComponent($this->queue['train'][$i]['id'], $moduleId);
     }
    }
   break;
   case 'trade':
    $this->getQueue('trade');
    $nr=count($this->queue['trade']);
    if ($nr)
    {
     $newIR=$oldIR=0;
     $moduleCount=0;
     foreach ($this->modules as $key=>$module)
      if ($module['module']==$moduleId)
      {
       if ($module['slot']!=$slotId) $newIR+=$module['input']*$game['modules'][$this->data['faction']][$module['module']]['ratio'];
       $oldIR+=$module['input']*$game['modules'][$this->data['faction']][$module['module']]['ratio'];
       $moduleCount++;
      }
     if ($useOldIR) $newIR=$oldIR;
     for ($i=0; $i<$nr; $i++)
     {
      if ($i) $this->queue['trade'][$i]['start']=$this->queue['trade'][$i-1]['start']+floor($this->queue['trade'][$i-1]['duration']*60);
      $this->queue['trade'][$i]['duration']=$game['users']['speed']['trade']*$this->queue['trade'][$i]['distance'];
      $this->queue['trade'][$i]['duration']=$this->queue['trade'][$i]['duration']-$this->queue['trade'][$i]['duration']*$newIR;
      $db->query('update trade set start="'.strftime('%Y-%m-%d %H:%M:%S', $this->queue['trade'][$i]['start']).'", duration="'.$this->queue['trade'][$i]['duration'].'" where id="'.$this->queue['trade'][$i]['id'].'"');
      //if (!$moduleCount) $this->cancelTrade($this->queue['trade'][$i]['id'], $moduleId);
     }
    }
   break;
  }
 }
 public function move($x, $y)
 {
  global $db, $game;
  $this->getModules();
  $this->getResources();
  $this->getLocation();
  $moveCost=$game['factions'][$this->data['faction']]['costs']['move'];
  $distance=ceil(sqrt(pow($this->location['x']-$x, 2)+pow($this->location['y']-$y, 2)));
  $moveCostData=$this->checkCost($moveCost, 'move');
  if ($moveCostData['ok'])
  {
   $node=new node();
   if ($node->get('id', $this->data['id'])=='done')
   {
    $sector=grid::getSector($x, $y);
    if ($sector['type']==1)
    {
     $ok=1;
     $db->query('update grid set type="1", id=floor(1+rand()*9) where x="'.$this->location['x'].'" and y="'.$this->location['y'].'"');
     if ($db->affected_rows()==-1) $ok=0;
     $this->location['x']=$x; $this->location['y']=$y;
     $db->query('update grid set type="2", id="'.$this->data['id'].'" where x="'.$this->location['x'].'" and y="'.$this->location['y'].'"');
     if ($db->affected_rows()==-1) $ok=0;
     foreach ($moveCost as $cost)
     {
      $this->resources[$cost['resource']]['value']-=$cost['value']*$game['users']['cost']['move'];
      $db->query('update resources set value="'.$this->resources[$cost['resource']]['value'].'" where node="'.$this->data['id'].'" and id="'.$cost['resource'].'"');
      if ($db->affected_rows()==-1) $ok=0;
     }
     if ($ok) $status='done';
     else $status='error';
    }
    else $status='invalidGridSector';
   }
   else $status='noNode';
  }
  else $status='notEnoughResources';
  return $status;
 }
 public static function doCombat($data)
 {
  global $game;
  $classes=array();
  foreach ($game['classes'] as $key=>$class)
  {
   $classes['attacker'][$key]=0;
   $classes['defender'][$key]=0;
  }
  $data['input']['attacker']['hp']=$data['input']['attacker']['damage']=$data['input']['attacker']['armor']=0;
  $data['input']['defender']['hp']=$data['input']['defender']['damage']=$data['input']['defender']['armor']=0;
  foreach ($data['input']['attacker']['groups'] as $key=>$group)//attacker stats
  {
   $data['input']['attacker']['groups'][$key]['hp']=$game['units'][$data['input']['attacker']['faction']][$group['unitId']]['hp']*$group['quantity'];
   $data['input']['attacker']['groups'][$key]['damage']=$game['units'][$data['input']['attacker']['faction']][$group['unitId']]['damage']*$group['quantity'];
   $data['input']['attacker']['groups'][$key]['armor']=$game['units'][$data['input']['attacker']['faction']][$group['unitId']]['armor']*$group['quantity'];
   $data['input']['attacker']['hp']+=$data['input']['attacker']['groups'][$key]['hp'];
   $data['input']['attacker']['damage']+=$data['input']['attacker']['groups'][$key]['damage'];
   $data['input']['attacker']['armor']+=$data['input']['attacker']['groups'][$key]['armor'];
   $classes['attacker'][$game['units'][$data['input']['attacker']['faction']][$group['unitId']]['class']]+=$data['input']['attacker']['groups'][$key]['damage'];
  }
  foreach ($data['input']['defender']['groups'] as $key=>$group)//defender stats
  {
   $data['input']['defender']['groups'][$key]['hp']=$game['units'][$data['input']['defender']['faction']][$group['unitId']]['hp']*$group['quantity'];
   $data['input']['defender']['groups'][$key]['damage']=$game['units'][$data['input']['defender']['faction']][$group['unitId']]['damage']*$group['quantity'];
   $data['input']['defender']['groups'][$key]['armor']=$game['units'][$data['input']['defender']['faction']][$group['unitId']]['armor']*$group['quantity'];
   $data['input']['defender']['hp']+=$data['input']['defender']['groups'][$key]['hp'];
   $data['input']['defender']['damage']+=$data['input']['defender']['groups'][$key]['damage'];
   $data['input']['defender']['armor']+=$data['input']['defender']['groups'][$key]['armor'];
   $classes['defender'][$game['units'][$data['input']['defender']['faction']][$group['unitId']]['class']]+=$data['input']['defender']['groups'][$key]['damage'];
  }
  foreach ($game['classes'] as $key=>$class)//classes ratios (damage bonus ratios)
  {
   if ($data['input']['attacker']['damage']) $classes['attacker'][$key]=$classes['attacker'][$key]/$data['input']['attacker']['damage'];
   if ($data['input']['defender']['damage']) $classes['defender'][$key]=$classes['defender'][$key]/$data['input']['defender']['damage'];
  }
  $data['input']['attacker']['trueDamage']=max($data['input']['attacker']['damage']-$data['input']['defender']['armor'], 0);
  $data['input']['defender']['trueDamage']=max($data['input']['defender']['damage']-$data['input']['attacker']['armor'], 0);
  $data['output']['attacker']['totalDamage']=$data['output']['defender']['totalDamage']=0;
  foreach ($data['input']['attacker']['groups'] as $key=>$group)
  {//attacker takes damage
   if ($data['input']['attacker'][$data['input']['defender']['focus']])
    $ratio=$group[$data['input']['defender']['focus']]/$data['input']['attacker'][$data['input']['defender']['focus']];
   else $ratio=0;
   $baseDamage=ceil($data['input']['defender']['trueDamage']*$ratio);
   $bonusDamage=0;
   foreach ($game['classes'][$game['units'][$data['input']['attacker']['faction']][$group['unitId']]['class']] as $classKey=>$damageMod)
    $bonusDamage+=floor($baseDamage*$classes['defender'][$classKey]*$damageMod);
   $damage=$baseDamage+$bonusDamage;
   $group['hp']=max($group['hp']-$damage, 0);
   if ($data['input']['attacker']['groups'][$key]['hp'])
    $ratio=$group['hp']/$data['input']['attacker']['groups'][$key]['hp'];
   else $ratio=0;
   $group['quantity']=floor($data['input']['attacker']['groups'][$key]['quantity']*$ratio);
   $data['output']['attacker']['groups'][$key]=$group;
   $data['output']['defender']['totalDamage']+=$damage;
  }
  foreach ($data['input']['defender']['groups'] as $key=>$group)
  {//defender takes damage
   if ($data['input']['defender'][$data['input']['attacker']['focus']])
    $ratio=$group[$data['input']['attacker']['focus']]/$data['input']['defender'][$data['input']['attacker']['focus']];
   else $ratio=0;
   $baseDamage=ceil($data['input']['attacker']['trueDamage']*$ratio);
   $bonusDamage=0;
   foreach ($game['classes'][$game['units'][$data['input']['defender']['faction']][$group['unitId']]['class']] as $classKey=>$damageMod)
    $bonusDamage+=floor($baseDamage*$classes['attacker'][$classKey]*$damageMod);
   $damage=$baseDamage+$bonusDamage;
   $group['hp']=max($group['hp']-$damage, 0);
   if ($data['input']['defender']['groups'][$key]['hp'])
    $ratio=$group['hp']/$data['input']['defender']['groups'][$key]['hp'];
   else $ratio=0;
   $group['quantity']=floor($data['input']['defender']['groups'][$key]['quantity']*$ratio);
   $data['output']['defender']['groups'][$key]=$group;
   $data['output']['attacker']['totalDamage']+=$damage;
  }
  if ($data['output']['defender']['totalDamage']>=$data['output']['attacker']['totalDamage'])
  {
   $data['output']['attacker']['winner']=0;
   $data['output']['defender']['winner']=1;
  }
  else
  {
   $data['output']['attacker']['winner']=1;
   $data['output']['defender']['winner']=0;
  }
  if ((!$data['input']['attacker']['hp'])&&(!$data['input']['defender']['hp']))
  {
   $data['output']['attacker']['winner']=0;
   $data['output']['defender']['winner']=0;
  }
  else if (($data['input']['attacker']['hp'])&&(!$data['input']['defender']['hp']))
  {
   $data['output']['attacker']['winner']=1;
   $data['output']['defender']['winner']=0;
  }
  return $data;
 }
}

class alliance
{
 public $data, $members, $invitations, $wars;
 public function get($idType, $id)
 {
  global $db;
  $result=$db->query('select * from alliances where '.$idType.'="'.$id.'"');
  $this->data=db::fetch($result);
  if (isset($this->data['id'])) $status='done';
  else $status='noAlliance';
  return $status;
 }
 public function set($nodeId)
 {
  global $db, $game;
  $alliance=new alliance();
  if ($alliance->get('id', $this->data['id'])=='done')
   if ($alliance->get('name', $this->data['name'])=='noAlliance')
   {
    $node=new node();
    if ($node->get('id', $nodeId)=='done')
    {
     $node->getResources();
     $setCost=$game['factions'][$node->data['faction']]['costs']['alliance'];
     $setCostData=$node->checkCost($setCost, 'alliance');
     if ($setCostData['ok'])
     {
      $ok=1;
      foreach ($setCost as $cost)
      {
       $node->resources[$cost['resource']]['value']-=$cost['value']*$game['users']['cost']['alliance'];
       $db->query('update resources set value="'.$node->resources[$cost['resource']]['value'].'" where node="'.$node->data['id'].'" and id="'.$cost['resource'].'"');
       if ($db->affected_rows()==-1) $ok=0;
      }
      $db->query('update alliances set name="'.$this->data['name'].'" where id="'.$this->data['id'].'"');
      if ($db->affected_rows()==-1) $ok=0;
      if ($ok) $status='done';
      else $status='error';
     }
     else $status='notEnoughResources';
    }
    else $status='noNode';
   }
   else $status='nameTaken';
  else $status='noAlliance';
  return $status;
 }
 public function add($nodeId)
 {
  global $db, $game;
  $alliance=new alliance();
  if ($alliance->get('name', $this->data['name'])=='noAlliance')
  {
   $node=new node();
   if ($node->get('id', $nodeId)=='done')
   {
    $node->checkResources(time());
    $addCost=$game['factions'][$node->data['faction']]['costs']['alliance'];
    $addCostData=$node->checkCost($addCost, 'alliance');
    if ($addCostData['ok'])
    {
     $ok=1;
     foreach ($addCost as $cost)
     {
      $node->resources[$cost['resource']]['value']-=$cost['value']*$game['users']['cost']['alliance'];
      $db->query('update resources set value="'.$node->resources[$cost['resource']]['value'].'" where node="'.$node->data['id'].'" and id="'.$cost['resource'].'"');
      if ($db->affected_rows()==-1) $ok=0;
     }
     $this->data['id']=misc::newId('alliances');
     $db->query('insert into alliances (id, user, name) values ("'.$this->data['id'].'", "'.$node->data['user'].'", "'.$this->data['name'].'")');
     if ($db->affected_rows()==-1) $ok=0;
     $db->query('update users set alliance="'.$this->data['id'].'" where id="'.$this->data['user'].'"');
     if ($db->affected_rows()==-1) $ok=0;
     if ($ok) $status='done';
     else $status='error';
    }
    else $status='notEnoughResources';
   }
   else $status='noNode';
  }
  else $status='nameTaken';
  return $status;
 }
 public static function remove($id)
 {
  global $db;
  $alliance=new alliance();
  if ($alliance->get('id', $id)=='done')
  {
   $ok=1;
   $db->query('delete from invitations where alliance="'.$id.'"');
   if ($db->affected_rows()==-1) $ok=0;
   $db->query('delete from wars where sender="'.$id.'" or recipient="'.$id.'"');
   if ($db->affected_rows()==-1) $ok=0;
   $db->query('insert into free_ids (id, type) values ("'.$id.'", "alliances")');
   if ($db->affected_rows()==-1) $ok=0;
   $db->query('delete from alliances where id="'.$id.'"');
   if ($db->affected_rows()==-1) $ok=0;
   if ($ok) $status='done';
   else $status='error';
  }
  else $status='noAlliance';
  return $status;
 }
 public function getMembers()
 {
  global $db;
  $result=$db->query('select * from users where alliance="'.$this->data['id'].'"');
  $this->members=array();
  for ($i=0; $row=db::fetch($result); $i++) $this->members[$i]=$row;
 }
 public static function getInvitations($column, $id)
 {
  global $db;
  $result=$db->query('select * from invitations where '.$column.'="'.$id.'"');
  $invitations=array();
  for ($i=0; $row=db::fetch($result); $i++) $invitations[$i]=$row;
  return $invitations;
 }
 public function addInvitation($userId)
 {
  global $db;
  $user=new user();
  if ($user->get('id', $userId)=='done')
  {
   $result=$db->query('select count(*) as count from invitations where alliance="'.$this->data['id'].'" and user="'.$userId.'"');
   $row=db::fetch($result);
   if (!$row['count'])
   {
    $ok=1;
    $db->query('insert into invitations (alliance, user) values ("'.$this->data['id'].'", "'.$user->data['id'].'")');
    if ($db->affected_rows()==-1) $ok=0;
    if ($ok) $status='done';
    else $status='error';
   }
   else $status='invitationSet';
  }
  else $status='noUser';
  return $status;
 }
 public static function removeInvitation($allianceId, $userId)
 {
  global $db;
  $alliance=new alliance();
  if ($alliance->get('id', $allianceId)=='done')
  {
   $user=new user();
   if ($user->get('id', $userId)=='done')
   {
    $result=$db->query('select count(*) as count from invitations where alliance="'.$allianceId.'" and user="'.$userId.'"');
    $row=db::fetch($result);
    if ($row['count'])
    {
     $db->query('delete from invitations where alliance="'.$allianceId.'" and user="'.$userId.'"');
     if ($db->affected_rows()>-1) $status='done';
     else $status='error';
    }
    else $status='noEntry';
   }
   else $status='noUser';
  }
  else $status='noAlliance';
  return $status;
 }
 public static function acceptInvitation($allianceId, $userId)
 {
  global $db;
  $alliance=new alliance();
  if ($alliance->get('id', $allianceId)=='done')
  {
   $user=new user();
   if ($user->get('id', $userId)=='done')
    if (!$user->data['alliance'])
    {
     $result=$db->query('select count(*) as count from invitations where alliance="'.$allianceId.'" and user="'.$userId.'"');
     $row=db::fetch($result);
     if ($row['count'])
     {
      $ok=1;
      $db->query('update users set alliance="'.$allianceId.'" where id="'.$userId.'"');
      if ($db->affected_rows()==-1) $ok=0;
      $db->query('delete from invitations where alliance="'.$allianceId.'" and user="'.$userId.'"');
      if ($db->affected_rows()==-1) $ok=0;
      if ($ok) $status='done';
      else $status='error';
     }
     else $status='noEntry';
    }
    else $status='allianceSet';
   else $status='noUser';
  }
  else $status='noAlliance';
  return $status;
 }
 public function removeMember($userId)
 {
  global $db;
  $user=new user();
  if ($user->get('id', $userId)=='done')
  {
   $db->query('update users set alliance=0 where id="'.$userId.'"');
   if ($db->affected_rows()>-1) $status='done';
   else $status='error';
  }
  else $status='noUser';
  return $status;
 }
 public function getWars()
 {
  global $db;
  $result=$db->query('select * from wars where sender="'.$this->data['id'].'" or recipient="'.$this->data['id'].'"');
  $this->wars=array();
  for ($i=0; $row=db::fetch($result); $i++) $this->wars[$i]=$row;
 }
 public function getWar($allianceId)
 {
  global $db;
  $result=$db->query('select * from wars where type=1 and (sender="'.$this->data['id'].'" and recipient="'.$allianceId.'") or (sender="'.$allianceId.'" and recipient="'.$this->data['id'].'")');
  $row=db::fetch($result);
  return $row;
 }
 public function addWar($allianceId)
 {
  global $db;
  $alliance=new alliance();
  if ($alliance->get('id', $allianceId)=='done')
  {
   $result=$db->query('select count(*) as count from wars where type=1 and (sender="'.$this->data['id'].'" or recipient="'.$this->data['id'].'")');
   $row=db::fetch($result);
   if (!$row['count'])
   {
    $db->query('insert into wars (type, sender, recipient) values ("1", "'.$this->data['id'].'", "'.$alliance->data['id'].'")');
    if ($db->affected_rows()>-1) $status='done';
    else $status='error';
   }
   else $status='warSet';
  }
  else $status='noAlliance';
  return $status;
 }
 public function proposePeace($allianceId)
 {
  global $db;
  $alliance=new alliance();
  if ($alliance->get('id', $allianceId)=='done')
  {
   $result=$db->query('select count(*) as count from wars where type=1 and ((sender="'.$this->data['id'].'" and recipient="'.$alliance->data['id'].'") or (sender="'.$alliance->data['id'].'" and recipient="'.$this->data['id'].'"))');
   $row=db::fetch($result);
   if ($row['count'])
   {
    $result=$db->query('select count(*) as count from wars where type=0 and ((sender="'.$this->data['id'].'" and recipient="'.$alliance->data['id'].'") or (sender="'.$alliance->data['id'].'" and recipient="'.$this->data['id'].'"))');
    $row=db::fetch($result);
    if (!$row['count'])
    {
     $db->query('insert into wars (type, sender, recipient) values ("0", "'.$this->data['id'].'", "'.$alliance->data['id'].'")');
     if ($db->affected_rows()>-1) $status='done';
     else $status='error';
    }
    else $status='peaceSet';
   }
   else $status='noWar';
  }
  else $status='noAlliance';
  return $status;
 }
 public function removePeace($allianceId)
 {
  global $db;
  $alliance=new alliance();
  if ($alliance->get('id', $allianceId)=='done')
  {
   $result=$db->query('select count(*) as count from wars where type=0 and ((sender="'.$this->data['id'].'" and recipient="'.$alliance->data['id'].'") or (sender="'.$alliance->data['id'].'" and recipient="'.$this->data['id'].'"))');
   $row=db::fetch($result);
   if ($row['count'])
   {
    $db->query('delete from wars where type=0 and ((sender="'.$this->data['id'].'" and recipient="'.$alliance->data['id'].'") or (sender="'.$alliance->data['id'].'" and recipient="'.$this->data['id'].'"))');
    if ($db->affected_rows()>-1) $status='done';
    else $status='error';
   }
   else $status='noPeace';
  }
  else $status='noAlliance';
  return $status;
 }
 public function acceptPeace($allianceId)
 {
  global $db;
  $alliance=new alliance();
  if ($alliance->get('id', $allianceId)=='done')
  {
   $result=$db->query('select count(*) as count from wars where type=0 and sender="'.$alliance->data['id'].'" and recipient="'.$this->data['id'].'"');
   $row=db::fetch($result);
   if ($row['count'])
   {
    $ok=1;
    $db->query('delete from wars where type=1 and ((sender="'.$this->data['id'].'" and recipient="'.$alliance->data['id'].'") or (sender="'.$alliance->data['id'].'" and recipient="'.$this->data['id'].'"))');
    if ($db->affected_rows()==-1) $ok=0;
    $db->query('delete from wars where type=0 and sender="'.$alliance->data['id'].'" and recipient="'.$this->data['id'].'"');
    if ($db->affected_rows()==-1) $ok=0;
    if ($ok) $status='done';
    else $status='error';
   }
   else $status='noPeace';
  }
  else $status='noAlliance';
  return $status;
 }
 public function getAll()
 {
  $this->getMembers();
  $this->invitations=alliance::getInvitations('alliance', $this->data['id']);
  $this->getWars();
 }
}

class message
{
 public $data;
 public function get($id)
 {
  global $db;
  $result=$db->query('select * from messages where id="'.$id.'"');
  $this->data=db::fetch($result);
  if (isset($this->data['id'])) $status='done';
  else $status='noMessage';
  return $status;
 }
 public function set()
 {
  global $db;
  $message=new message();
  if ($message->get($this->data['id'])=='done')
  {
   $db->query('update messages set viewed="'.$this->data['viewed'].'" where id="'.$this->data['id'].'"');
   if ($db->affected_rows()>-1) $status='done';
   else $status='error';
  }
  else $status='noMessage';
  return $status;
 }
 public function add()
 {
  global $db;
  $recipient=new user();
  if ($recipient->get('name', $this->data['recipient'])=='done')
  {
   $sender=new user();
   if ($sender->get('name', $this->data['sender'])=='done')
    if (!$sender->isBlocked($recipient->data['id']))
    {
     $this->data['id']=misc::newId('messages');
     $sent=strftime('%Y-%m-%d %H:%M:%S', time());
     $db->query('insert into messages (id, sender, recipient, subject, body, sent, viewed) values ("'.$this->data['id'].'", "'.$sender->data['id'].'", "'.$recipient->data['id'].'", "'.$this->data['subject'].'", "'.$this->data['body'].'", "'.$sent.'", "'.$this->data['viewed'].'")');
     if ($db->affected_rows()>-1) $status='done';
     else $status='error';
    }
    else $status='blocked';
   else $status='noSender';
  }
  else $status='noRecipient';
  return $status;
 }
 public static function remove($id)
 {
  global $db;
  $message=new message();
  if ($message->get($id)=='done')
  {
   $ok=1;
   $db->query('insert into free_ids (id, type) values ("'.$id.'", "messages")');
   if ($db->affected_rows()==-1) $ok=0;
   $db->query('delete from messages where id="'.$id.'"');
   if ($db->affected_rows()==-1) $ok=0;
   if ($ok) $status='done';
   else $status='error';
  }
  else $status='noMessage';
  return $status;
 }
 public static function removeAll($userId)
 {
  global $db;
  $result=$db->query('select id from messages where recipient="'.$userId.'"');
  $ok=1;
  while ($row=db::fetch($result))
  {
   $db->query('insert into free_ids (id, type) values ("'.$row['id'].'", "messages")');
   if ($db->affected_rows()==-1) $ok=0;
   $db->query('delete from messages where id="'.$row['id'].'"');
   if ($db->affected_rows()==-1) $ok=0;
  }
  if ($ok) $status='done';
  else $status='error';
  return $status;
 }
 public static function getList($recipient, $limit, $offset)
 {
  global $db;
  $messages=array();
  $messages['messages']=array();
  $result=$db->query('select count(*) as count from messages where recipient="'.$recipient.'"');
  $row=db::fetch($result);
  $messages['count']=$row['count'];
  $result=$db->query('select * from messages where recipient="'.$recipient.'" order by sent desc limit '.$limit.' offset '.$offset);
  for ($i=0; $row=db::fetch($result); $i++)
  {
   $messages['messages'][$i]=new message();
   $messages['messages'][$i]->data=$row;
  }
  return $messages;
 }
 public static function getUnreadCount($recipient)
 {
  global $db;
  $result=$db->query('select count(*) as count from messages where recipient="'.$recipient.'" and viewed=0');
  $row=db::fetch($result);
  return $row['count'];
 }
}
?>