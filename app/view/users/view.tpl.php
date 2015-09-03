<h1><?=$user->getProperties()['name']?></h1>

<table>
  <tbody>
    <tr><th>Id</th><th>Akronym</th><th>Namn</th><th>Epost</th><th>Aktiverad</th><th>Skapad</th><th></th><th></th></tr>
    <tr>
    <td><?=$user->getProperties()['id']?></td>
    <td><?=$user->getProperties()['acronym']?></td>
    <td><?=$user->getProperties()['name']?></td>
    <td><?=$user->getProperties()['email']?></td>
    <td><?=$user->getProperties()['active']?></td>
    <td><?=$user->getProperties()['created']?></td>
    <td><a href="update/<?=$user->getProperties()['id']?>">Ändra</a></td>
    <td><a href="delete/<?=$user->getProperties()['id']?>">Ta bort</a></td>
    </tr>
  </tbody>
</table>
 
<p><a href='<?=$this->url->create('')?>'>Home</a></p>