<?php

class Notification
{
    public function fetchNotificationsInfo($userNotif)
    {
        // si le user n'est pas bloque...
        // construction des where pour la query.
        foreach ($notifications as $key => $value) {
            if ($value === null) {
                continue;
            }
            if ($value == 'like') {
            }
            if ($value == 'unmatch') {
            }
            if ($value == 'visiter') {
            }
            if ($value == 'addroomMessage') {
            }
        }
        // prendre le user associe avec la room. (type, nom, prenom, lien vers la room)
      // prendre le user associe avec la visite. (type, nom, prenom, lien vers le profil)
      // prendre le user associe avec le like recu. (type, nom, prenom, lien vers le profil)
      // prendre le user associe avec le user qui a like en retour. (type, nom, prenom, lien vers le profil)
      // prendre le user match qui disLike. (type, nom, prenom, lien vers le profil)
      // quand les notifs sont vues => delete de la table.
    }
}
