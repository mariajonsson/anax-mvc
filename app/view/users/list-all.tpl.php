<h1><?=$title?></h1>
<table>
  <tbody>
    
<tr><th>id</th><th></th><th>användare</th><th>namn</th><th></th></th></tr>
    <?php foreach ($users as $user) : ?>
    <?php 
    $class = "";
    if ($user->getProperties()['deleted'] != null) {
      $faclass = "fa fa-user-times fa-fw";
      $class = "user-deleted";
    }
    elseif ($user->getProperties()['active'] == null) {
      $faclass = "fa fa-user fa-fw";
      $class = "user-inactive";
    }
    else {
      $faclass = "fa fa-user fa-fw";
      $class = "user-active";
    } ?>
    <tr">
    <td><?=$user->getProperties()['id']?></td>
    <td><a 
href="<?=$this->url->create('users/activate').'/'.$user->getProperties()['id'].'
/'.$this->request->getRoute()?> "  
class="<?=$class?>"><i class="<?=$faclass." ".$class?>"></i></a></td>
    <td><a 
href="<?=$this->url->create('users/id').'/'.$user->getProperties()['id']?>"  
class="<?=$class?>"><?=$user->getProperties()['acronym']?></a></td>
    <td><?=$user->getProperties()['name']?></td>
    <td>
    <?php if ($user->getProperties()['deleted'] == null) : ?>
    <a 
href="<?=$this->url->create('users/update').'/'.$user->getProperties()['id']?>" 
title='Ändra'><i class="fa fa-pencil"></i>
</a><?php endif; ?>
    </td>
    <td>
    <?php if ($user->getProperties()['deleted'] == null) : ?>
    <a 
href="<?=$this->url->create('users/soft-delete').'/'.$user->getProperties()['id'
]?>" title='Ta bort'><i class="fa fa-trash"></i>
</a>
    <?php endif; ?>
    </td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
