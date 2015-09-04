<h1><?=$title?></h1>
<table>
  <tbody>
    <tr><th>Id</th><th>Akronym</th><th>Namn</th><th></th></th></tr>
    <?php foreach ($users as $user) : ?>
    <tr>
    <td><?=$user->getProperties()['id']?></td>
    <td><a href="<?=$this->url->create('users/id').'/'.$user->getProperties()['id']?>"><?=$user->getProperties()['acronym']?></a></td>
    <td><?=$user->getProperties()['name']?></td>
    <td><a href="<?=$this->url->create('users/update').'/'.$user->getProperties()['id']?>">Ändra</a></td>
    <td><a href="<?=$this->url->create('users/delete').'/'.$user->getProperties()['id']?>">Ta bort</a></td>
    </tr>
    <?php endforeach; ?>
  </tbody>
</table>
 

 
<p><a href='<?=$this->url->create('')?>'>Home</a></p>