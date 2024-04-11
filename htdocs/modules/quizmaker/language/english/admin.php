<?php
   /**
 * Name: modinfo.php
 * Description:
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package : XOOPS
 * @Module : 
 * @subpackage : Menu Language
 * @since 2.5.7
 * @author Jean-Jacques DELALANDRE (jjdelalandre@orange.fr)
 * @version {version}
 * Traduction:  
 */
 
defined( 'XOOPS_ROOT_PATH' ) or die( 'Accès restreint' );

// fonctionnalité de clonage
//define('_AM_QUIZMAKER_CAPTION', "Titre");            
//define('_AM_QUIZMAKER_FORM_TYPE_DESC', "Utiliser pour les type \"pageGroup\" pour caractériser un slide d'introduction, un simple encart ou le slide de résuluat.");
//define('_AM_QUIZMAKER_WEIGHT', "Poids");            
\define('_AM_QUIZMAKER_ALLOW_ALL_ORDER', "Aurorise l'ordre inverse");
\define('_AM_QUIZMAKER_CLONE', "Clone");
\define('_AM_QUIZMAKER_CLONE_CONGRAT', "Félicitations ! %s a été créé avec succès !<br>Vous voudrez peut-être apporter des modifications aux fichiers de langue.");
\define('_AM_QUIZMAKER_CLONE_DSC', "Cloner un module n'a jamais été aussi facile ! Tapez simplement le nom que vous souhaitez lui donner et appuyez sur le bouton Soumettre !");
\define('_AM_QUIZMAKER_CLONE_EXISTS', "ERREUR : Nom du module déjà pris, veuillez en essayer un autre !");
\define('_AM_QUIZMAKER_CLONE_FAIL', "Désolé, nous n'avons pas réussi à créer le nouveau clone. Peut-être avez-vous besoin de définir temporairement des autorisations d'écriture (CHMOD 777) sur le dossier des modules et de réessayer.");
\define('_AM_QUIZMAKER_CLONE_IMAGEFAIL', "Attention, nous n'avons pas réussi à créer le nouveau logo du module. Veuillez envisager de modifier manuellement assets/images/logo_module.png !");
\define('_AM_QUIZMAKER_CLONE_INVALIDNAME', "ERREUR : nom de module invalide, veuillez en essayer un autre !");
\define('_AM_QUIZMAKER_CLONE_NAME', "Choisissez un nom pour le nouveau module");
\define('_AM_QUIZMAKER_CLONE_NAME_DSC', "N'utilisez pas de caractères spéciaux ! <br>Ne choisissez pas un nom de répertoire de module ou un nom de table de base de données existant !");
\define('_AM_QUIZMAKER_CLONE_TITLE', "Clone %s");
\define('_AM_QUIZMAKER_EXPORT_QUIZ', "Exportation du Quiz");
\define('_AM_QUIZMAKER_ONLY_ORDER_NAT', "Uniquement l'ordre indiqué dans la question");
\define('_AM_QUIZMAKER_ONLY_ORDERT', "Uniquement l'ordre indiqué dans la question");
\define('_AM_QUIZMAKER_ORIENTATION', "Orientation");
\define('_AM_QUIZMAKER_ORIENTATION_GROUPS', "Orientation des groupes");
\define('_AM_QUIZMAKER_ORIENTATION_H', "Horizontale");
\define('_AM_QUIZMAKER_Orientation_HBR', "Orientation horizontale des bonnes réponses");
\define('_AM_QUIZMAKER_ORIENTATION_V', "Verticale");
\define('_AM_QUIZMAKER_Orientation_VBR', "Orientation verticale des bonnes réponses");
\define('_AM_QUIZMAKER_PARAMETRES', "Paramètres");
\define('_AM_QUIZMAKER_QUIZ_SHOW_SCORE_MIN_MAX', "Afficher les scores min et max");
\define('_AM_QUIZMAKER_QUIZ_SHOW_SCORE_MIN_MAX_DESC', "Les scores min et max seront affichés au dessus de la question lors de l'exécution du quiz");
\define('_AM_QUIZMAKER_SHOW_ALL_SOLUTIONS_DESC', "<b>Oui</b> : Permet d'afficher les solutions qui ne rapportent pas de points ou qui ont une note négative<br><b>Non</b> : Affiche que les solutions qui ont une note positive");
\define('_AM_QUIZMAKER_THEME_DEFAULT_CAT', "Thème par défaut pour cette catégorie");
\define('_AM_QUIZMAKER_VIEW_ALL_SOLUTIONS', "Afficher toutes les solutions");
\define('_AM_QUIZMAKER_ACTIF', "Actif");
\define('_AM_QUIZMAKER_ACTIF_DESC', "La question sera exclus du quiz sans la supprimer.");
\define('_AM_QUIZMAKER_ACTION', "Action");
\define('_AM_QUIZMAKER_ACTIONS', "Actions");
\define('_AM_QUIZMAKER_ADD_ANSWERS', "Ajouter de nouvelles réponses");
\define('_AM_QUIZMAKER_ADD_CATEGORIES', "Ajouter de nouvelles catégories");
\define('_AM_QUIZMAKER_ADD_MESSAGES', "Ajouter de nouveaux messages");
\define('_AM_QUIZMAKER_ADD_NEW_ANSWER', "Ajouter une proposition");
\define('_AM_QUIZMAKER_ADD_NEW_QUESTION', "<== Ajouer une nouvelle question");
\define('_AM_QUIZMAKER_ADD_QUESTIONS', "Ajouter de nouvelles questions");
\define('_AM_QUIZMAKER_ADD_QUIZ', "Ajouter un nouveau quiz");
\define('_AM_QUIZMAKER_ANSWERS_ADD', "Ajouter des réponses");
\define('_AM_QUIZMAKER_ANSWERS_EDIT', "Modifier les réponses");
\define('_AM_QUIZMAKER_ANSWERS_ID', "Id");
\define('_AM_QUIZMAKER_ANSWERS_LIST', "Liste de réponses");
\define('_AM_QUIZMAKER_ANSWERS_GROUP', "Groupe");
\define('_AM_QUIZMAKER_ANSWERS_POINTS', "Points");
\define('_AM_QUIZMAKER_ANSWERS_PROPOSITION', "Proposition");
\define('_AM_QUIZMAKER_ANSWERS_QUESTION_ID', "Question id");
\define('_AM_QUIZMAKER_AUTO', "Automatique");
\define('_AM_QUIZMAKER_BAD_PROPOSITIONS', "Mauvaises réponses");            
\define('_AM_QUIZMAKER_BUILD_QUIZ', "Générer le quiz");
\define('_AM_QUIZMAKER_BUTTONS_COLOR', "Couleur des boutons");            
\define('_AM_QUIZMAKER_CAPTION', "Titre");
\define('_AM_QUIZMAKER_CARS_TO_REPLACE', "Caractères de remplacement");            
\define('_AM_QUIZMAKER_CAT_NOT_EMPTY', "La catégorie n'est pas vide");
\define('_AM_QUIZMAKER_CATEGORIES', "Catégories");
\define('_AM_QUIZMAKER_CATEGORIES_ADD', "Ajouter des catégories");
\define('_AM_QUIZMAKER_CATEGORIES_DESCRIPTION', "Description");
\define('_AM_QUIZMAKER_CATEGORIES_EDIT', "Modifier les catégories");
\define('_AM_QUIZMAKER_CATEGORIES_ID', "Identifiant");
\define('_AM_QUIZMAKER_CATEGORIES_LIST', "Liste des catégories");
\define('_AM_QUIZMAKER_CATEGORIES_NAME', "Nom");
\define('_AM_QUIZMAKER_CATEGORIES_THEME', "Thème");
\define('_AM_QUIZMAKER_CATEGORY', "Catégorie");
\define('_AM_QUIZMAKER_CHRONO', "Chronomètre");
\define('_AM_QUIZMAKER_CLICK_DOUBLE', "double click");
\define('_AM_QUIZMAKER_CLICK_SIMPLE', "Simple click");
\define('_AM_QUIZMAKER_COMPUTE_WEIGHT', "Initialisation du poids");
\define('_AM_QUIZMAKER_CONFIG_DEV', "Configuration pour le developpement");
\define('_AM_QUIZMAKER_CONFIG_PROD', "Configuration en production");
\define('_AM_QUIZMAKER_CONFIGS_OPTIONS', "Configurations");
\define('_AM_QUIZMAKER_CONFIRM_RAS_RESULTS', "Confirmer la suppression des résultats du quiz <b>%s (#%s) ?</b>");
\define('_AM_QUIZMAKER_CREATION', "Création");
\define('_AM_QUIZMAKER_DATE_BEGIN_END', "Dates début/fin");
\define('_AM_QUIZMAKER_DATEBEGIN', "Date début");
\define('_AM_QUIZMAKER_DATEEND', "Date fin");
\define('_AM_QUIZMAKER_DELETE', "Supprimer");            
\define('_AM_QUIZMAKER_DELETE_RESULTS_OK', "Suppression des résultats ok");
\define('_AM_QUIZMAKER_DESCRIPTION', "Description");
\define('_AM_QUIZMAKER_DESCRIPTION_DESC', "Texte affiché sur la page d'introduction du quiz");
\define('_AM_QUIZMAKER_DOWN', "Redescendre");
\define('_AM_QUIZMAKER_DOWNLOAD_OK', "Le téléchargement va démarrer. Si il ne démarre pas cliquer sur le lien direct ici ===>");
\define('_AM_QUIZMAKER_EXPLANATION', "Explication");
\define('_AM_QUIZMAKER_EXPLANATION_DESC', "Ce texte sera affiché avec les solutions pour les commenter.");
\define('_AM_QUIZMAKER_EXPORT_QUIZ_YML', "Export YML du quiz");
\define('_AM_QUIZMAKER_EXPORT_YML', "Export YML");
\define('_AM_QUIZMAKER_EXPORTER', "Exporter");
\define('_AM_QUIZMAKER_FILE_DESC', "Un nouveau quiz sera généré");
\define('_AM_QUIZMAKER_FOLDER_JS', "Fichier");
\define('_AM_QUIZMAKER_FILE_NAME_JS', "Fichier Java script");
\define('_AM_QUIZMAKER_FILE_NAME_JS_DESC', "La nom du fichier ne doit contenir ni espace, ni caractère accentués.");
\define('_AM_QUIZMAKER_FILE_TO_LOAD', "Fichier YAML à télécharger");
\define('_AM_QUIZMAKER_FILE_UPLOADSIZE', "Taile maximum des fichiers %s mo");
\define('_AM_QUIZMAKER_FIRST', "Enoyer au début");
\define('_AM_QUIZMAKER_FORM_DELETE', "Dégager");
\define('_AM_QUIZMAKER_FORM_DELETE_OK', "Supprimé avec succès");
\define('_AM_QUIZMAKER_FORM_OK', "Enregistré avec succès");
\define('_AM_QUIZMAKER_FORM_SURE_DELETE', "Êtes-vous sûr de supprimer : <b><span style='color : Red;'>%s </span></b>");
\define('_AM_QUIZMAKER_FORM_TYPE', "Type de formulaire");
\define('_AM_QUIZMAKER_FORM_TYPE_SHORT', "Formulaire");
\define('_AM_QUIZMAKER_GROUP', "Groupe");      
\define('_AM_QUIZMAKER_GROUP_LIB', "Libellé du groupe");      
\define('_AM_QUIZMAKER_GROUP0', "Panier");      
\define('_AM_QUIZMAKER_GROUP_ALL', "Tous les groupes");      
\define('_AM_QUIZMAKER_ID', "[#]");
\define('_AM_QUIZMAKER_IMAGE', "Image");
\define('_AM_QUIZMAKER_IMG_FLIP', "Echange les images");
\define('_AM_QUIZMAKER_IMG_HEIGHT', "Hauteur des images");
\define('_AM_QUIZMAKER_IMG_HEIGHT1', "Hauteur de l'image");
\define('_AM_QUIZMAKER_IMG_INSERT', "Insert et décale les images");
\define('_AM_QUIZMAKER_IMG_SUBSTITUT', "Image de Substitution");            
\define('_AM_QUIZMAKER_IMG_TO_LOAD', "Image");            
\define('_AM_QUIZMAKER_IMPORT', "Importation");
\define('_AM_QUIZMAKER_IMPORT_QUIZ_YML', "Import YML du quiz");
\define('_AM_QUIZMAKER_IMPORT_YML', "Import YML");
\define('_AM_QUIZMAKER_IMPORTER', "Importer");
\define('_AM_QUIZMAKER_INPUTS', "Nombre de zones de saisie");
\define('_AM_QUIZMAKER_ISQUESTION', "Est une question");
\define('_AM_QUIZMAKER_ISQUESTION_DESC', "Non pour les slides d'intro encarts et résultats.<br>laissez oui pour les autres");
\define('_AM_QUIZMAKER_LAST', "Enoyer à la fin");
\define('_AM_QUIZMAKER_LEGEND', "Légende");
\define('_AM_QUIZMAKER_LEGEND_DESC', "Texte affiché sur la page d'introduction du quiz");
\define('_AM_QUIZMAKER_NUM_LOWERCASE', "a b c ...");
\define('_AM_QUIZMAKER_MAINTAINEDBY', "  est maintenu par");
\define('_AM_QUIZMAKER_MESSAGES_ADD', "Ajouter des messages");
\define('_AM_QUIZMAKER_MESSAGES_CODE', "Code");
\define('_AM_QUIZMAKER_MESSAGES_CONSTANT', "Constante");
\define('_AM_QUIZMAKER_MESSAGES_EDIT', "Modifier les messages");
\define('_AM_QUIZMAKER_MESSAGES_ID', "Id");
\define('_AM_QUIZMAKER_MESSAGES_LIST', "Liste des messages");
\define('_AM_QUIZMAKER_MESSAGES_MESSAGE', "Message");
\define('_AM_QUIZMAKER_MOVE_MODE', "Mode de déplacement");
\define('_AM_QUIZMAKER_NAME', "Nom");
\define('_AM_QUIZMAKER_NB_QUIZ', "Nb Quiz");
\define('_AM_QUIZMAKER_NO_PERMISSIONS_SET', "Aucune autorisation définie");
\define('_AM_QUIZMAKER_NONE', "Aucun");
\define('_AM_QUIZMAKER_NONEE', "Aucune");            
\define('_AM_QUIZMAKER_NOT_QUESTION', "Ce n'est pas une question");
\define('_AM_QUIZMAKER_NUMBERING', "Numérotation");
\define('_AM_QUIZMAKER_NUM_NUMERIQUE', "1 2 3 ...");
\define('_AM_QUIZMAKER_OPTIONS', "Options");
\define('_AM_QUIZMAKER_SPECIFIC_OPTIONS', "Options spécifiques");
\define('_AM_QUIZMAKER_OPTIONS_FOR_DEV', "Options pour le développement - Laiser  \"Non\" ces options en production");
\define('_AM_QUIZMAKER_OPTIONS_FOR_QUIZ', "Options du quiz");
\define('_AM_QUIZMAKER_PARENT', "Parent");
\define('_AM_QUIZMAKER_PARENT_ID', "ID Parent");
\define('_AM_QUIZMAKER_PERIODE', "Période");
\define('_AM_QUIZMAKER_PERMISSIONS', "Gestion des permissions");
\define('_AM_QUIZMAKER_PERMISSIONS_APPROVE', "Autorisations d'approbation");
\define('_AM_QUIZMAKER_PERMISSIONS_APPROVE_DESC', "Autorisations d'approbation");
\define('_AM_QUIZMAKER_PERMISSIONS_GLOBAL', "Autorisations globales");
\define('_AM_QUIZMAKER_PERMISSIONS_GLOBAL_16', "Autorisations globales pour afficher");
\define('_AM_QUIZMAKER_PERMISSIONS_GLOBAL_4', "Autorisations globales à approuver");
\define('_AM_QUIZMAKER_PERMISSIONS_GLOBAL_8', "Autorisations globales pour soumettre");
\define('_AM_QUIZMAKER_PERMISSIONS_GLOBAL_DESC', "Autorisations globales pour vérifier le type de.");
\define('_AM_QUIZMAKER_PERMISSIONS_SUBMIT', "Autorisations de soumission");
\define('_AM_QUIZMAKER_PERMISSIONS_SUBMIT_DESC', "Autorisations de soumission");
\define('_AM_QUIZMAKER_PERMISSIONS_VIEW', "Autorisations de voir");
\define('_AM_QUIZMAKER_PERMISSIONS_VIEW_DESC', "Autorisations de voir");
\define('_AM_QUIZMAKER_PIXELS', "px");            
\define('_AM_QUIZMAKER_POINTS', "Points");            
\define('_AM_QUIZMAKER_PROPOSITIONS', "Propositions");
\define('_AM_QUIZMAKER_PROPOSITIONS_ANSWERS', "Propositions de réponses");
\define('_AM_QUIZMAKER_SLIDE_OPTIONS', "Opions du slide");            
\define('_AM_QUIZMAKER_SLIDE_CONSIGNE', "Aide du slide");            
\define('_AM_QUIZMAKER_PUBLISH', "Publication");
\define('_AM_QUIZMAKER_PUBLISH_ANSWERS', "Publier les réponses");
\define('_AM_QUIZMAKER_PUBLISH_AUTO_DESC', "Automatique : quand le quiz est cloturé");
\define('_AM_QUIZMAKER_PUBLISH_QUIZ_DESC', "Défini le mode d'exécution, dans l'interface du site ou en indépenament du site<br>en mode autonome, les scores ne seront pas engistrés");
\define('_AM_QUIZMAKER_PUBLISH_RESULTS', "Publier les résultats");
\define('_AM_QUIZMAKER_QUESTION', "Question");
\define('_AM_QUIZMAKER_QUESTIONS', "Questions");
\define('_AM_QUIZMAKER_QUESTIONS_ADD', "Ajouter des questions");
\define('_AM_QUIZMAKER_QUESTIONS_COMMENT1', "Commentaires");
\define('_AM_QUIZMAKER_QUESTIONS_COMMENT1_DESC', "Les balises <b>{scoreMaxiQQ}</b> et <b>{timer}</b> seront remplacées par leurs valeurs respectives.");
\define('_AM_QUIZMAKER_QUESTIONS_COMMENT2', "Commentaire");
\define('_AM_QUIZMAKER_QUESTIONS_CREATION', "Date de création");
\define('_AM_QUIZMAKER_QUESTIONS_EDIT', "Modifier les questions");
\define('_AM_QUIZMAKER_QUESTIONS_ID', "Id");
\define('_AM_QUIZMAKER_QUESTIONS_LEARN_MORE', "En savoir plus");
\define('_AM_QUIZMAKER_QUESTIONS_LEARN_MORE_DESC', "Défini un lien sur une page externe");
\define('_AM_QUIZMAKER_QUESTIONS_LIST', "Liste de questions");
\define('_AM_QUIZMAKER_QUESTIONS_MINREPONSE', "Minimum de réponses");
\define('_AM_QUIZMAKER_QUESTIONS_MINREPONSE2', "Min rép.");
\define('_AM_QUIZMAKER_QUESTIONS_NB_POINTS', "Nombre de points");            
\define('_AM_QUIZMAKER_QUESTIONS_POINTS', "Points");            
\define('_AM_QUIZMAKER_QUESTIONS_POINTS_DESC', "<b>Important :</b><br>Si <b>points == 0</b> alors c'est le nombre de points affectés aux bonnes et mauvaises réponses qui seront comptées<br>Si <b>points > 0</b>, c'est cette valeur qui sera utilisée pour le score.<br><b>Dans tous les cas</b> il faut affecter un nombre de points aux bonnes réponses pour les identifier et calculer le bon score.");            
\define('_AM_QUIZMAKER_QUESTIONS_QUESTION', "Question");
\define('_AM_QUIZMAKER_QUESTIONS_QUESTION_DESC', "Utilisez le caractère \"/\" pour insérer un retour à la ligne dans la question si nécéssaire.");
\define('_AM_QUIZMAKER_QUESTIONS_QUIZ_ID', "Quiz id");
\define('_AM_QUIZMAKER_QUESTIONS_SEE_ALSO', "Voir aussi");
\define('_AM_QUIZMAKER_QUESTIONS_SEE_ALSO_DESC', "Défini un lien sur une page externe");
\define('_AM_QUIZMAKER_QUESTIONS_TEXT_TO_CORRECT', "Texte à corriger");
\define('_AM_QUIZMAKER_QUESTIONS_TYPE_QUESTION', "Type question");
\define('_AM_QUIZMAKER_QUIZ', "Quiz");
\define('_AM_QUIZMAKER_QUIZ_ADD', "Ajout d'un nouveau quiz");
\define('_AM_QUIZMAKER_QUIZ_ALLOWEDPREVIOUS', "Retour arrière");
\define('_AM_QUIZMAKER_QUIZ_ALLOWEDPREVIOUS_DESC', "Autoriser à revenir sur les questions prcédentes");
\define('_AM_QUIZMAKER_QUIZ_ALLOWEDSUBMIT', "Bouton de soummission");
\define('_AM_QUIZMAKER_QUIZ_ALLOWEDSUBMIT_DESC', "Affiche le bouton de soumission pour valider les réponses");
\define('_AM_QUIZMAKER_QUIZ_ANSWERBEFORENEXT', "Réponse obligatoire");
\define('_AM_QUIZMAKER_QUIZ_ANSWERBEFORENEXT_DESC', "L'utilisateur doit faire une réponse avant de passer à la question suivante");
\define('_AM_QUIZMAKER_QUIZ_AUTHOR', "Auteur");
\define('_AM_QUIZMAKER_QUIZ_BUILD', "Génération");
\define('_AM_QUIZMAKER_QUIZ_EDIT', "Édition du Quiz");
\define('_AM_QUIZMAKER_QUIZ_ID', "Identifiant");
\define('_AM_QUIZMAKER_QUIZ_LIST', "Liste des quiz");
\define('_AM_QUIZMAKER_QUIZ_MINUS_OSGA', "Diminue le score");
\define('_AM_QUIZMAKER_QUIZ_MINUS_OSGA_DESC', "Diminue le score si le bouton \"Bonnes réponses\" est visible et cliquée");
\define('_AM_QUIZMAKER_QUIZ_NAME', "Nom");
\define('_AM_QUIZMAKER_QUIZ_ONCLICK', "Action sur clique souris");
\define('_AM_QUIZMAKER_QUIZ_PRESENTATION', "Présentation du quiz");
\define('_AM_QUIZMAKER_QUIZ_RESULT_POPUP', "Afficher le résultat dans un popup");
\define('_AM_QUIZMAKER_QUIZ_RESULT_POPUP_DESC', "permet d'afficher le résultat  de la question courante dans un popup lors du passage à la suivante.<br>Permet d'avoirune idée du résultat global au fure et à mesure, surtout si le retour arrière est bloqué");
\define('_AM_QUIZMAKER_QUIZ_RESULTATS', "Résultats");
\define('_AM_QUIZMAKER_QUIZ_RESULTATS_DESC', "<ul style='text-align: left;'><li><span style='font-size: large; font-family: arial, helvetica, sans-serif;'>Nombre de r&eacute;ponses faites : {repondu} / {totalQuestions}</span><br /><span style='font-size: large; font-family: arial, helvetica, sans-serif;'></span></li><li><span style='font-size: large; font-family: arial, helvetica, sans-serif;'><strong>Votre score est de {score} / {scoreMaxiQQ}</strong><span style='color: #ff0000;'> (score minimum : {scoreMiniQQ})</span> </span><br /><span style='font-size: large; font-family: arial, helvetica, sans-serif;'></span></li><li><span style='font-size: large; font-family: arial, helvetica, sans-serif;'>Votre temps de r&eacute;ponse est de {duree}</span></li></ul>");
\define('_AM_QUIZMAKER_QUIZ_SHOW_BAD_ANSWERS', "Bouton \"Mauvaises réponses\"");
\define('_AM_QUIZMAKER_QUIZ_SHOW_BAD_ANSWERS_DESC', "Utiliser pour le développement, laisser non en production.");
\define('_AM_QUIZMAKER_QUIZ_SHOW_BTN_RELOAD_ANSWERS', "Bouton \"Réinitialiser\"");
\define('_AM_QUIZMAKER_QUIZ_SHOW_BTN_RELOAD_ANSWERS_DESC', "Permet de réinitialiser la question courante.");
\define('_AM_QUIZMAKER_QUIZ_SHOW_GOOD_ANSWERS', "Bouton \"Bonnes réponses\"");
\define('_AM_QUIZMAKER_QUIZ_SHOW_GOOD_ANSWERS_DESC', "Utiliser pour le développement, laisser non en production.");
\define('_AM_QUIZMAKER_QUIZ_SHOW_RELOAD_ANSWERS', "Bouton \"Recharger\"");
\define('_AM_QUIZMAKER_QUIZ_SHOW_TYPE_QUESTION', "Afficher le type de question");
\define('_AM_QUIZMAKER_QUIZ_SHOW_TYPE_QUESTION_DESC', "Affiche le type de question dans l'entête du slide sous la question.<br>Utilisé pour la mise au point du quiz, laissez \"Non\" en production<br>Affiche également l'id du quiz et de la question");
\define('_AM_QUIZMAKER_QUIZ_SHOWLOG', "Montrer les logs");
\define('_AM_QUIZMAKER_QUIZ_SHOWLOG_DESC', "Utilisé lors du développement, afffiche des informations d'action ou de valeur.<br>Laisser non en production.");
\define('_AM_QUIZMAKER_QUIZ_SHOWREPONSES', "Afficher les réponses");
\define('_AM_QUIZMAKER_QUIZ_SHOWREPONSES_BOTTOM', "Afficher les réponses");
\define('_AM_QUIZMAKER_QUIZ_SHOWREPONSES_BOTTOM_DESC', "Permet d'afficher les réponses en bas de page.<br>A utiliser en mode développement ou préparation d'un quiz");
\define('_AM_QUIZMAKER_QUIZ_SHOWRESULTALLWAYS', "Résultat global");
\define('_AM_QUIZMAKER_QUIZ_SHOWRESULTALLWAYS_DESC', "Affiche le résultat global dans le bandeau du bas");
\define('_AM_QUIZMAKER_QUIZ_SHUFFLE_QUESTION', "Mélanger les questions");
\define('_AM_QUIZMAKER_QUIZ_SHUFFLE_QUESTION_DESC', "Ne pas utiliser si l'ordre des questions est important ou si des \"Encarts\" ont été utilisés");
\define('_AM_QUIZMAKER_QUIZ_USE_TIMER', "Utiliser un chronomètre");
\define('_AM_QUIZMAKER_QUIZ_USE_TIMER_DESC', "Si oui utilise le délai paramètré dans les questions pour enchainer les questions, réponse faite ou  non");
\define('_AM_QUIZMAKER_RAZ_RESULTS', "Effacer les résultats de ce quiz");
\define('_AM_QUIZMAKER_REPARTITION', "Répartition");
\define('_AM_QUIZMAKER_REPARTITION_ALEATOIRE1', "Répartition aléatoire sur la liste de gauche uniquement");
\define('_AM_QUIZMAKER_REPARTITION_ALEATOIRE2', "Répartition aléatoire sur les deux listes");
\define('_AM_QUIZMAKER_RESTOR_QUIZ_YML', "Restauration YML du quiz");
\define('_AM_QUIZMAKER_RESTOR_YML', "Restauration YML");
\define('_AM_QUIZMAKER_RESULTS_CREATION', "Creation");
\define('_AM_QUIZMAKER_RESULTS_DURATION', "Durée");
\define('_AM_QUIZMAKER_RESULTS_ID', "Id");
\define('_AM_QUIZMAKER_RESULTS_LIST', "Liste des résultats");
\define('_AM_QUIZMAKER_RESULTS_NBANSWERS', "Nonbre de réponses");
\define('_AM_QUIZMAKER_RESULTS_NOTE', "Note");
\define('_AM_QUIZMAKER_RESULTS_QUIZ_ID', "Quiz id");
\define('_AM_QUIZMAKER_RESULTS_SCORE', "Score");
\define('_AM_QUIZMAKER_RESULTS_SCORE_MAX', "Score maximum");
\define('_AM_QUIZMAKER_RESULTS_SCORE_MIN', "Score minimum");
\define('_AM_QUIZMAKER_SCORE', "Score");
\define('_AM_QUIZMAKER_SELECT_CATEGORY_DESC', "Sélectionnez une catégorie de destintion pour ce nouveau quiz.<br>Catégorie d'origine recherchera une catégorie du même nom que la catégorie d'origine.<br>Si elle n'est pas trouvée elle sera créée.");
\define('_AM_QUIZMAKER_SELECT_CATEGORY_ORG', "Catégorie d'origine");
\define('_AM_QUIZMAKER_SELECT_TYPE_BEFORE_ADD', "Sélectionnez un type de question avant d'ajouter une nouvelle question");
\define('_AM_QUIZMAKER_SEQUENCE', "Séquence logique correcte");            
\define('_AM_QUIZMAKER_SEQUENCE0', "Séquence à trouver");            
\define('_AM_QUIZMAKER_SEQUENCE1', "Images proposées");            
\define('_AM_QUIZMAKER_SEQUENCEH', "Hauteur en pixels des images");            
\define('_AM_QUIZMAKER_SHORTDESC', "Description courte");
\define('_AM_QUIZMAKER_SHUFFLE_ANS', "Mélanger les propositions");
\define('_AM_QUIZMAKER_SHUFFLE_ANS_DESC', "Change l'ordre des réponses à chaque fois que le quiz est lancé.<br>Les propositions seront donc numérotées différemment à chaque fois.<br>Attention certains types de questions peuvent ne pas changer l'ordre.");
\define('_AM_QUIZMAKER_SIZE0', "Hauteur des images à regrouper");      
\define('_AM_QUIZMAKER_SIZE1', "Hauteur des images dans les groupes");      
\define('_AM_QUIZMAKER_SLIDE_001', "Points par mot trouvé");
\define('_AM_QUIZMAKER_SLIDE_002', "Elements décrivant un objet");
\define('_AM_QUIZMAKER_SLIDE_003', "Liste des options proposées");
\define('_AM_QUIZMAKER_SLIDE_004', "Points par mauvais mot");
\define('_AM_QUIZMAKER_SLIDE_CAPTION0', "Titre de la liste");
\define('_AM_QUIZMAKER_SLIDE_CAPTION1', "Titre de la liste 1");
\define('_AM_QUIZMAKER_SLIDE_CAPTION2', "Titre de la liste 2");
\define('_AM_QUIZMAKER_SLIDE_INPUTS', "Entrées");
\define('_AM_QUIZMAKER_SLIDE_LABEL', "Libellé");
\define('_AM_QUIZMAKER_SLIDE_MOT', "Mot");
\define('_AM_QUIZMAKER_SLIDE_POINT', "Point");
\define('_AM_QUIZMAKER_SLIDE_POINTS', "Points");
\define('_AM_QUIZMAKER_SLIDE_PROPO', "Proposition");
\define('_AM_QUIZMAKER_SLIDE_TEXTE', "Texte");
\define('_AM_QUIZMAKER_SLIDE_TEXTES', "Textes");
\define('_AM_QUIZMAKER_SLIDE_TITLE', "Titre");
\define('_AM_QUIZMAKER_SLIDE_WEIGHT', "Poids");
\define('_AM_QUIZMAKER_STATISTICS', "Statistiques");
\define('_AM_QUIZMAKER_STRANGER_EXP', "<b>Expressions étrangères au texte</b>");
\define('_AM_QUIZMAKER_SUBMIT_AND_ADDNEW', "Soumettre et ajouter");
\define('_AM_QUIZMAKER_SUBSTITUT_IMG', "Image de substitution");            
\define('_AM_QUIZMAKER_TEST_QUIZ', "Teste quiz version");
\define('_AM_QUIZMAKER_TEXTE', "Texte");
\define('_AM_QUIZMAKER_THEME', "Thème");
\define('_AM_QUIZMAKER_THEME_DESC', "Laisser vide pour utiliser le thème de la catégorie");
\define('_AM_QUIZMAKER_THEREARE_ANSWERS', "Il y a <span class='bold'>%s</span> réponses dans la base de données");
\define('_AM_QUIZMAKER_THEREARE_CATEGORIES', "Il y a <span class='bold'>%s</span> catégories dans la base de données");
\define('_AM_QUIZMAKER_THEREARE_MESSAGES', "Il y a <span class='bold'>%s</span> messages dans la base de données");
\define('_AM_QUIZMAKER_THEREARE_QUESTIONS', "Il y a <span class='bold'>%s</span> questions dans la base de données");
\define('_AM_QUIZMAKER_THEREARE_QUIZ', "Il y a <span class='bold'>%s</span> quiz dans la base de données");
\define('_AM_QUIZMAKER_THEREARE_RESULTS', "Il y a <span class='bold'>%s</span> résultats dans la base de données");
\define('_AM_QUIZMAKER_THEREARE_TYPE_QUESTION', "Il y a <span class='bold'>%s</span> type_question dans la base de données");
\define('_AM_QUIZMAKER_THEREARENT_ANSWERS', "Il n'y a pas de réponses");
\define('_AM_QUIZMAKER_THEREARENT_CATEGORIES', "Il n'y a pas de catégories");
\define('_AM_QUIZMAKER_THEREARENT_MESSAGES', "Il n'y a pas de messages");
\define('_AM_QUIZMAKER_THEREARENT_QUESTIONS', "Il n'y a pas de questions");
\define('_AM_QUIZMAKER_THEREARENT_QUIZ', "Il n'y a pas de quiz");
\define('_AM_QUIZMAKER_THEREARENT_RESULTS', "Il n'y a pas de résultats");
\define('_AM_QUIZMAKER_TIMER', "Chronomètre");
\define('_AM_QUIZMAKER_TIMER_DESC', "Indiquer le temps d'affichage en secondes de la question avant de passer à la suivante.<br>Cette options n'est active que si le paramètre \"Utiliser un chronomètre\" du quiz est activé");
\define('_AM_QUIZMAKER_TYPE', "Type");
\define('_AM_QUIZMAKER_TYPE_QUESTION_CATEGORY', "Types de questions");            
\define('_AM_QUIZMAKER_UP', "Remonter");
\define('_AM_QUIZMAKER_UPDATE', "Mise à jour");
\define('_AM_QUIZMAKER_NUM_UPPERCASE', "A B C ...");
\define('_AM_QUIZMAKER_VISIBLE', "Visible");
\define('_AM_QUIZMAKER_VISIBLE_DESC', "La question ne sera pas générée dans le quiz.");
\define('_AM_QUIZMAKER_WEIGHT', "Poids");
\define('_AM_QUIZMAKER_PURGER_IMAGES', "Purger les images");
\define('_AM_QUIZMAKER_QUIZ_PURGER_IMAGES', "Suprime toutes les images du quiz non référencées");
\define('_AM_QUIZMAKER_QUIZ_IMAGES_DELETED', "%s images supprimées");
\define('_AM_QUIZMAKER_NEW', "Nouveau");
\define('_AM_QUIZMAKER_MESSAGES_LANGUAGE', "Langue");
\define('_AM_QUIZMAKER_LOAD_JS_LANGUAGES_FILES', "Charger les fichiers de langues");
\define('_AM_QUIZMAKER_SAVE_JS_LANGUAGES_FILES', "Générer les fichiers de langues");
\define('_AM_QUIZMAKER_MESSAGES_LOADED', "Chargement des fichiers de langue terminé");
\define('_AM_QUIZMAKER_MESSAGES_SAVED', "Exportation des fichiers de langue terminée");

\define('_AM_QUIZMAKER_SHOW_CAPTIONS', "Affichage des titres de images");
\define('_AM_QUIZMAKER_SHOW_CAPTIONS_NONE', "Aucun");
\define('_AM_QUIZMAKER_SHOW_CAPTIONS_TOP', "Au-dessus");
\define('_AM_QUIZMAKER_SHOW_CAPTIONS_BOTTOM', "Au-dessous");
\define('_AM_QUIZMAKER_BTN_HEIGHT', "Hauteur des boutons");
\define('_AM_QUIZMAKER_ORDER_ALLOWED', "Ordre autorisé");
\define('_AM_QUIZMAKER_SHOW_BTN_GOTO_SLIDE', "Bouton \"Atteindre le slide\"");
\define('_AM_QUIZMAKER_SHOW_BTN_GOTO_SLIDE_DESC', "Affiche le bouton 'Goto Slide' utilisé pendant la mise au point d'un quiz. Laissez \"Non\" en production.");
\define('_AM_QUIZMAKER_PP', " : ");
\define('_AM_QUIZMAKER_GROUP_DEFAULT', "Groupe par défaut");
\define('_AM_QUIZMAKER_PUBLISH_ACTIF', "Publié");
\define('_AM_QUIZMAKER_QUIZ_SHOW_GOTO_SLIDE', "Aller au slide");
\define('_AM_QUIZMAKER_LANGUAGE', "Langue");

define('_AM_QUIZMAKER_TOOLS', "Outils");
define('_AM_QUIZMAKER_CODE', "Code");
define('_AM_QUIZMAKER_TOOLS_MINIFIER', "Minifier");
define('_AM_QUIZMAKER_TOOLS_RESTAURE', "Restaurer");

define('_AM_QUIZMAKER_TOOLS_FOLDER_ALL_DESC', "Tous les fichiers js, css, language et plugins");
define('_AM_QUIZMAKER_TOOLS_FOLDER_APP_DESC', "Dossier js");
define('_AM_QUIZMAKER_TOOLS_FOLDER_PLUGINS_DESC', "Dossier plugins");
define('_AM_QUIZMAKER_TOOLS_FOLDER_CSS_DESC', "Dossier css");
define('_AM_QUIZMAKER_TOOLS_FOLDER_HTML_DESC', "Dossier htmd");
define('_AM_QUIZMAKER_TOOLS_MINIFY_LANGUAGE_DESC', "Dossier language");
                        
define('_AM_QUIZMAKER_TOOLS_RESTAURE_OK', "Restauration des fichiers OK");
define('_AM_QUIZMAKER_TOOLS_MINIFIE_OK', "Minification des fichiers OK");

define('_AM_QUIZMAKER_QUIZ_SHOW_CONSIGNE', "Bouton d'aide");
define('_AM_QUIZMAKER_QUIZ_SHOW_CONSIGNE_DESC', "Affiche le bouton d'aide des types de question ssous la forme d'un point d'interrotgation");

define('_AM_QUIZMAKER_QUESTIONS_IDENTIFIANT', "Identifiant");
define('_AM_QUIZMAKER_QUESTIONS_IDENTIFIANT_DESC', "Cet identifiant est utilisé avec la fonction javascript \"gotoSlide\" utilisable dans les textes des slides.<br>Si il n'est pas unique, la fonction affichera le premier slide trouvé avec cet identifiant.<br>Il peut être composé de lettres et de chiffres<br>exemple d'utilisation dans un texte d'une page de groupe:<br>&lt;a href=\"#\" onclick=\"gotoSlide('identifiant');\"&gt;" );

define('_AM_QUIZMAKER_QUESTIONS_CONSIGNE', "Consigne");
define('_AM_QUIZMAKER_QUESTIONS_CONSIGNE_DESC', "Texte affiché quand le bouton \"Help\" est survolé.<br>Par défaut si le champ est laissé vide c'est la consigne définie dans les classe des type de questions qui est reprise." );

define('_AM_QUIZMAKER_POSITION_NONE', "Invisible");
define('_AM_QUIZMAKER_POSITION_TL', "Haut gauche");
define('_AM_QUIZMAKER_POSITION_TR', "Haut droite");
define('_AM_QUIZMAKER_POSITION_BR', "Bas droite");
define('_AM_QUIZMAKER_POSITION_BL', "Bas gauche");

define('_AM_QUIZMAKER_UL_WIDTH', "Largeur des items");
define('_AM_QUIZMAKER_ALL_GROUPS', "Tous les groupes");

define('_AM_QUIZMAKER_DISPOSITION', "Disposition des groupes");
define('_AM_QUIZMAKER_DISPOSITION_DESC', "<b>Important</b> : Sélectionnez une disposition qui corresponde au nombre de groupes qui on été définis.");
define('_AM_QUIZMAKER_COLOR', "Couleur du texte");
define('_AM_QUIZMAKER_BACKGROUND', "Couleur du fond");

define('_AM_QUIZMAKER_FAMILY_WORDS', "Famille de mots");
define('_AM_QUIZMAKER_FAMILY_WORDS_DESC', "Cette liste de mots séparée par une virgule  permet d'orienter les réponses.<br>exemple trouver les termes ayant un point commun avec cette liste.<br>Elle sera affichée à côté de la liste d'options.");
define('_AM_QUIZMAKER_NEW_', "_NEW_");

define('_AM_QUIZMAKER_MINIFY',"Minification");

//define('_SUBMIT_ALL',"submit_all");
define('_AM_QUIZMAKER_MINIFY_ALL',"Minifier tous les fichiers sauf lang");
define('_AM_QUIZMAKER_MINIFY_JS',"Minifier le JS");
define('_AM_QUIZMAKER_MINIFY_CSS',"Minifier les CSS");
define('_AM_QUIZMAKER_MINIFY_HTML',"Minifier les HTML");
define('_AM_QUIZMAKER_MINIFY_LANGUAGE',"Minifier les fichiers de langues");

define('_AM_QUIZMAKER_MINIFY_RESTAURE_ORG',"Restaure les originaux");

define('_AM_QUIZMAKER_MINIFY_SELECTION',"Minifier la sélection");
define('_AM_QUIZMAKER_MINIFY_RESTAURE_OK',"Restaure OK");
define('_AM_QUIZMAKER_IS_MINIFED',"Minifié");
           
?>
