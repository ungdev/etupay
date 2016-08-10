### Processus de paiment ###

## Cycle de la demande ##

Service -> Gateway -> Banque -> Gateway -> Service
                             -> callback banque -> gateway
                                                            -> callback service jusqu'a aquitement (retry) (HTTP CODE 200)

#Etape 1: Transmettre la requete de paiment à l'api #


Variable requise:
    -> id: Id numérique du service autorisé a utiliser l'API
    -> payload: base64(AES-256-CBC(key_Service,json(parametres))
    
Parametres:
-> action: "Checkout"
-> amount: Montant en centime d'euros
-> description: (optionnel) Description de la transaction: serat présent sur la facture et le ticket du client
-> client_mail: (optionnel) Adresse mail du client, permet l'envoi automatique du ticket de transaction ainsi que la facture PDF (?option)
-> service_data: (optionnel) champs libre retourné lors du callback

#Etape 2: Gateway:

Si traitement positif de la requete: affichage du montant de la transaction et des moyens de paiment

#Etape 3: Traitement du moyen de paiment

#Etape 4: Renvoi sur callback du service en fonction de l'état de la transaction

#Etape 5: Callback de la gateway sur le service en fonction de l'état de la transaction

La gateway transmettra continuellement le callback jusqu'à aquitement via un HTTP_CODE 200

Variables POST:
    -> payload: base64(AES-256-CBC(key_service,json(parametres))

Parametres:

-> transaction_id
-> amount
-> type ['PAYMENT', 'AUTHORISATION']
-> step ['INITIALISED', 'PAID', 'REFUSED', 'REFUNDED', 'AUTHORISATION', 'CANCELED']
-> service_data

### Fct API

#Descrypt
$crypt = new Encrypter(base64_decode($this->key), 'AES-256-CBC');
        if($this->checkKey($this->key))
            return $crypt->decrypt($payload);
        else
            throw new \Exception('Cannot decrypt the payload');

#Crypt
$crypt = new Encrypter(base64_decode($this->key), 'AES-256-CBC');
        return $crypt->encrypt(json_encode([param]));
