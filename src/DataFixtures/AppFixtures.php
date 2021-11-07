<?php

namespace App\DataFixtures;

use PasswordHasher;
use App\Entity\User;
use App\Entity\Skill;
use App\Entity\Status;
use DateTimeImmutable;
use App\Entity\Company;
use App\Entity\Profile;
use App\Entity\Category;
use App\Entity\Experience;
use App\Entity\Profession;
use App\Entity\SkillLevel;
use App\Entity\ProfileSkill;
use App\Entity\TypeDocument;
use App\Entity\TypeExperience;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AppFixtures extends Fixture
{
    const FAKE_SKILLS_CATEGORIES = [
        ['Langages'],
        ['Frameworks'],
        ['CMS']
    ];

    const FAKE_SKILLS = [
        ['HTML', 'Langages'],
        ['CSS', 'Langages'],
        ['Javascript', 'Langages'],
        ['PHP', 'Langages'],
        ['Symfony', 'Frameworks'],
        ['React', 'Frameworks'],
        ['Laravel', 'Frameworks'],
        ['NodeJS', 'Frameworks'],
        ['Wordpress', 'CMS'],
        ['Wix', 'CMS'],
        ['Omeka', 'CMS'],
        ['Spip', 'CMS'],
    ];

    const FAKE_SKILLS_LEVELS = [
        ['Junior'],
        ['Medium'],
        ['Senior'],
        ['Expert']
    ];

    const FAKE_STATII = [
        ['candidat'],
        ['collaborateur'],
        ['a quitté l\'entreprise']
    ];

    const FAKE_PROFESSIONS = [
        ['Webdesigner'],
        ['Développeur/euse'],
        ['Concepteur/rice d\'application'],
        ['Architecte logiciel'],
        ['Technicien/enne réseau'],
        ['Technicien/enne d\'assistance informatique'],
        ['Webmarketer'],
        ['Devops'],
        ['Data analyst'],
        ['Data scientist'],
    ];

    const FAKE_DOCUMENT_TYPES = [
        ['CV'],
        ['Lettre de motivation'],
        ['Autres']
    ];

    const FAKE_EXPERIENCE_TYPES = [
        ['Stage'],
        ['Apprentissage'],
        ['Prestation'],
        ['Mission'],
        ['Formation']
    ];

    const FAKE_COMPANIES = [
        ['CEFIM', 'cefim@mail.test', '0247123456'],
        ['Wild Code School', 'wildcodeschool@mail.test', '0247654321'],
        ['Université de Tours', 'universitédetours@mail.test', '0247543210'],
        ['Mairie de Tours', 'mairiedetours@mail.test', '0247432109'],
        ['Métropole de Tours', 'métropole@mail.test', '0247321098'],
        ['Umanis', 'umanis@mail.test', '0247210987'],
        ['Apside', 'apside@mail.test', '0247109876'],
        ['Arctic', 'arctic@mail.test', '0247098765'],
        ['MGEN Mutuelle', 'mgen@mail.test', '0247234567'],
        ['MCD Mutuelle', 'mcd@mail.test', '0247345678'],
        ['CNAV', 'cnav@mail.test', '0247456789'],
        ['Prototyper', 'prototyper@mail.test', '0247567890'],
        ['La Mobilerie', 'lamobilerie@mail.test', '0247678901'],
        ['Code Troopers', 'codetroopers@mail.test', '0247789012'],
        ['Baddack', 'baddack@mail.test', '0247890123'],
        ['Open', 'open@mail.test', '0247901234'],
        ['Auchan', 'auchan@mail.test', '0247012345'],
        ['Institut Aurélie Favre', 'auréliefavre@mail.test', '0247246802'],
        ['Start&Growth', 'startandgrowth@mail.test', '0247135791'],
        ['SEDIPEC', 'sedipec@mail.test', '0247134679'],
        ['Radio Béton', 'radiobéton@mail.test', '0247579052'],
    ];

    const FAKE_PROFILES = [
        ['Jérôme', 'Salmon', '8, rue de Laply', '37000', 'Tours', '0612345678', 'hyeronimus@mail.test', 'Développeur/euse', 'collaborateur', 0, '2020-01-01', null],
        ['Ludivine', 'Sagnole', '34, rue de Lidéheux', '37567', 'Tape-sur-Leclavier', '0623456789', 'sagnole@mail.test', 'Développeur/euse', 'collaborateur', 0, '2020-04-23', null],
        ['Antoine', 'Jezequel', '67, boulevard du Techos', '53897', 'Doctechnique', '0634567890', 'jezequel@mail.test', 'Architecte logiciel', 'candidat', 1, '2020-02-15', null],
        ['Leandro', 'Nicolas', '134, avenue Do Brasil', '34975', 'Géhune-Kestion', '0645678901', 'nicolas@mail.test', 'Technicien/enne d\'assistance informatique', 'candidat', 1, '2020-05-03', null],
        ['Edouard', 'Lamy', '01, rue de la Maquette', '87234', 'Adobe', '0656789012', 'lamy@mail.test', 'Webdesigner', 'collaborateur', 1, '2021-10-11', null],
        ['Nicolas', 'Mormiche', '43, rue de la Casquette', '45739', 'Laforce-Tranquille', '0667890123', 'mormiche@mail.test', 'Devops', 'collaborateur', 0, '2021-07-24', null],
        ['Nicolas', 'Marcaud', '102, rue Nicolas Ier', '84209', 'Romanov', '0678901234', 'marcaud@mail.test', 'Concepteur/rice d\'application', 'collaborateur', 1, '2020-01-30', null],
        ['Florian', 'Fortier', '67, rue du Gaming', '69444', 'Jeuvidéheau', '0689012345', 'fortier@mail.test', 'Webdesigner', 'candidat', 1, '2021-06-02', null],
        ['Patrick', 'Yim', '86, avenue de la Discrétion', '52900', 'Colebach', '0690123456', 'yim@mail.test', 'Data scientist', 'candidat', 1, '2020-12-18', null],
        ['Kevin', 'Bertheau', '54, avenue du Fauteuil', '68512', 'Joie-du-Code', '0601234567', 'bertheau@mail.test', 'Technicien/enne réseau', 'collaborateur', 1, '2020-09-21', null],
        ['Ludovic', 'Brault', '102, avenue de l\'Exploration', '42000', 'Triquy', '0698765432', 'brault@mail.test', 'Architecte logiciel', 'collaborateur', 0, '2020-08-13', null],
        ['Dimitri', 'Guillon', '23, route de la Tranquilité', '23870', 'Hautbois', '0687654321', 'guillon@mail.test', 'Développeur/euse', 'candidat', 1, '2021-10-03', null],
        ['Adrien', 'Cauvin', '64, boulevard de Chinon', '45000', 'Alacoule', '0676543210', 'cauvin@mail.test', 'Webmarketer', 'candidat', 1, '2020-08-30', null],
        ['Alan', 'Daunay', '64, route du Canada', '40000', 'Daunay-sous-Bois', '0665432109', 'daunay@mail.test', 'Concepteur/rice d\'application', 'collaborateur', 0, '2020-11-11', null],
        ['Baptiste', 'Ternoir', '10, rue Onlygihesse', '58232', 'Javascript-Forever', '0654321098', 'ternoir@mail.test', 'Data scientist', 'collaborateur', 0, '2021-02-01', null],
    ];

    const FAKE_USERS = [
        ['JSalmon', ['ROLE_ADMIN'], 'admin_test', '2020-01-01', 'jsalmon@mail.test', ['Jérôme', 'Salmon']],
        ['LSagnole', ['ROLE_COMMERCIAL'], 'commercial_test', '2021-01-12', 'lsagnole@mail.test', ['Ludivine', 'Sagnole']],
        ['ADupont', ['ROLE_COMMERCIAL'], 'commercial_test', '2020-03-16', 'adupont@mail.test', null],
        ['MAuger', ['ROLE_COMMERCIAL'], 'commercial_test', '2021-11-07', 'mauger@mail.test', null],
        ['BLawniczak', ['ROLE_ADMIN'], 'admin_test', '2020-07-09', 'blawniczak@mail.test', null],
        ['NBrondinBernard', ['ROLE_COMMERCIAL'], 'commercial_test', '2020-07-20', 'nbrondinbernard@mail.test', null],
        ['LEvelin', ['ROLE_COMMERCIAL'], 'commercial_test', '2020-09-27', 'levelin@mail.test', null],
        ['ELamy', ['ROLE_COLLABORATEUR'], 'collab_test', '2021-10-11', 'elamy@mail.test', ['Edouard', 'Lamy']],
        ['NMormiche', ['ROLE_COLLABORATEUR'], 'collab_test', '2021-07-24', 'nmormiche@mail.test', ['Nicolas', 'Mormiche']],
        ['NMarcaud', ['ROLE_COLLABORATEUR'], 'collab_test', '2020-01-30', 'nmarcaud@mail.test', ['Nicolas', 'Marcaud']],
        ['KBertheau', ['ROLE_COLLABORATEUR'], 'collab_test', '2020-09-21', 'kbertheau@mail.test', ['Kevin', 'Bertheau']],
        ['ADaunay', ['ROLE_COLLABORATEUR'], 'collab_test', '2020-11-11', 'adaunay@mail.test', ['Alan', 'Daunay']],
        ['Bternoir', ['ROLE_COLLABORATEUR'], 'collab_test', '2021-02-01', 'bternoir@mail.test', ['Baptiste', 'ternoir']],
    ];

    const FAKE_PROFILES_HAS_SKILLS = [
        [0, 'HTML', ['Jérôme', 'Salmon'], 'senior'],
        [1, 'CSS', ['Jérôme', 'Salmon'], 'junior'],
        [1, 'Symfony', ['Jérôme', 'Salmon'], 'medium'],
        [0, 'Wordpress', ['Jérôme', 'Salmon'], 'expert'],
        [1, 'HTML', ['Ludivine', 'Sagnole'], 'senior'],
        [1, 'Javascript', ['Ludivine', 'Sagnole'], 'medium'],
        [0, 'Laravel', ['Ludivine', 'Sagnole'], 'junior'],
        [1, 'Spip', ['Ludivine', 'Sagnole'], 'expert'],
        [0, 'HTML', ['Antoine', 'Jezequel'], 'expert'],
        [0, 'CSS', ['Antoine', 'Jezequel'], 'expert'],
        [1, 'PHP', ['Antoine', 'Jezequel'], 'medium'],
        [1, 'Wordpress', ['Antoine', 'Jezequel'], 'expert'],
        [0, 'HTML', ['Leandro', 'Nicolas'], 'junior'],
        [1, 'Symfony', ['Leandro', 'Nicolas'], 'senior'],
        [1, 'React', ['Leandro', 'Nicolas'], 'junior'],
        [0, 'Wix', ['Leandro', 'Nicolas'], 'medium'],
        [1, 'PHP', ['Edouard', 'Lamy'], 'expert'],
        [1, 'CSS', ['Edouard', 'Lamy'], 'senior'],
        [1, 'Javascript', ['Edouard', 'Lamy'], 'medium'],
        [0, 'Omeka', ['Edouard', 'Lamy'], 'junior'],
        [0, 'React', ['Nicolas', 'Mormiche'], 'expert'],
        [0, 'Spip', ['Nicolas', 'Mormiche'], 'medium'],
        [1, 'NodeJS', ['Nicolas', 'Mormiche'], 'senior'],
        [1, 'Laravel', ['Nicolas', 'Mormiche'], 'junior'],
        [1, 'CSS', ['Nicolas', 'Marcaud'], 'expert'],
        [1, 'PHP', ['Nicolas', 'Marcaud'], 'medium'],
        [0, 'Wordpress', ['Nicolas', 'Marcaud'], 'junior'],
        [0, 'Spip', ['Nicolas', 'Marcaud'], 'expert'],
        [1, 'HTML', ['Florian', 'Fortier'], 'junior'],
        [1, 'CSS', ['Florian', 'Fortier'], 'expert'],
        [0, 'Javascript', ['Florian', 'Fortier'], 'junior'],
        [0, 'Laravel', ['Florian', 'Fortier'], 'junior'],
        [1, 'CSS', ['Patrick', 'Yim'], 'expert'],
        [1, 'PHP', ['Patrick', 'Yim'], 'senior'],
        [1, 'NodeJS', ['Patrick', 'Yim'], 'junior'],
        [0, 'React', ['Patrick', 'Yim'], 'senior'],
        [1, 'HTML', ['Kevin', 'Bertheau'], 'expert'],
        [0, 'Javascript', ['Kevin', 'Bertheau'], 'junior'],
        [1, 'Omeka', ['Kevin', 'Bertheau'], 'medium'],
        [0, 'HTML', ['Kevin', 'Bertheau'], 'medium'],
        [1, 'Javascript', ['Ludovic', 'Brault'], 'medium'],
        [1, 'NodeJS', ['Ludovic', 'Brault'], 'junior'],
        [0, 'Wordpress', ['Ludovic', 'Brault'], 'expert'],
        [0, 'Laravel', ['Ludovic', 'Brault'], 'senior'],
        [1, 'PHP', ['Dimitri', 'Guillon'], 'junior'],
        [0, 'Symfony', ['Dimitri', 'Guillon'], 'medium'],
        [1, 'Wix', ['Dimitri', 'Guillon'], 'expert'],
        [1, 'Laravel', ['Dimitri', 'Guillon'], 'junior'],
        [0, 'CSS', ['Adrien', 'Cauvin'], 'junior'],
        [1, 'HTML', ['Adrien', 'Cauvin'], 'medium'],
        [0, 'Javascript', ['Adrien', 'Cauvin'], 'senior'],
        [1, 'PHP', ['Adrien', 'Cauvin'], 'expert'],
        [0, 'React', ['Alan', 'Daunay'], 'senior'],
        [0, 'NodeJS', ['Alan', 'Daunay'], 'medium'],
        [0, 'Spip', ['Alan', 'Daunay'], 'junior'],
        [0, 'Javascript', ['Alan', 'Daunay'], 'expert'],
        [1, 'Javascript', ['Baptiste', 'Ternoir'], 'expert'],
        [1, 'React', ['Baptiste', 'Ternoir'], 'expert'],
        [1, 'NodeJS', ['Baptiste', 'Ternoir'], 'expert'],
        [1, 'Wordpress', ['Baptiste', 'Ternoir'], 'expert'],
    ];

    const FAKE_EXPERIENCES = [
        ['Stagiaire', 'Tours', '2020-11-15', '2021-02-04', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas malesuada augue eget urna ultricies, eu placerat nisi dapibus. Proin euismod tincidunt tempus. Vivamus commodo lorem vel neque interdum pretium. Etiam ut mattis dolor, sed porttitor ante. Mauris euismod erat sed egestas blandit. Vivamus vel velit magna. Pellentesque vel justo eget sapien laoreet suscipit a et orci. Nam posuere ex orci, at dignissim purus sagittis convallis. Proin sed lacus sed est ullamcorper volutpat. Vivamus tempor sodales consectetur. Vestibulum nibh elit, ullamcorper sit amet eros nec, pharetra tincidunt sapien. Donec porta elit pretium ullamcorper sollicitudin. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Donec fermentum, mauris et consequat tristique, diam lectus ultricies augue, non rutrum mauris magna eu dolor. Sed id cursus nisl. Curabitur ornare faucibus neque id sagittis.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vitae', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vitae.', 'Lorem ipsum dolor sit amet.', 'Université de Tours', 'Stage', ['Jérôme', 'Salmon']],
        ['Apprenti', 'Tours', '2021-02-04', '2021-09-20', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas malesuada augue eget urna ultricies, eu placerat nisi dapibus. Proin euismod tincidunt tempus. Vivamus commodo lorem vel neque interdum pretium. Etiam ut mattis dolor, sed porttitor ante. Mauris euismod erat sed egestas blandit. Vivamus vel velit magna. Pellentesque vel justo eget sapien laoreet suscipit a et orci. Nam posuere ex orci, at dignissim purus sagittis convallis. Proin sed lacus sed est ullamcorper volutpat. Vivamus tempor sodales consectetur. Vestibulum nibh elit, ullamcorper sit amet eros nec, pharetra tincidunt sapien. Donec porta elit pretium ullamcorper sollicitudin. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Donec fermentum, mauris et consequat tristique, diam lectus ultricies augue, non rutrum mauris magna eu dolor. Sed id cursus nisl. Curabitur ornare faucibus neque id sagittis.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vitae.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vitae.', 'Lorem ipsum dolor sit amet.', 'MGEN Mutuelle', 'Apprentissage', ['Jérôme', 'Salmon']],
        ['Développeur', 'Tours', '2021-09-20', null, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas malesuada augue eget urna ultricies, eu placerat nisi dapibus. Proin euismod tincidunt tempus. Vivamus commodo lorem vel neque interdum pretium. Etiam ut mattis dolor, sed porttitor ante. Mauris euismod erat sed egestas blandit. Vivamus vel velit magna. Pellentesque vel justo eget sapien laoreet suscipit a et orci. Nam posuere ex orci, at dignissim purus sagittis convallis. Proin sed lacus sed est ullamcorper volutpat. Vivamus tempor sodales consectetur. Vestibulum nibh elit, ullamcorper sit amet eros nec, pharetra tincidunt sapien. Donec porta elit pretium ullamcorper sollicitudin. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Donec fermentum, mauris et consequat tristique, diam lectus ultricies augue, non rutrum mauris magna eu dolor. Sed id cursus nisl. Curabitur ornare faucibus neque id sagittis.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vitae.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vitae.', 'Lorem ipsum dolor sit amet.', 'CNAV', 'Mission', ['Jérôme', 'Salmon']],
        ['Conceptrice', 'Tours', '2021-03-11', null, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas malesuada augue eget urna ultricies, eu placerat nisi dapibus. Proin euismod tincidunt tempus. Vivamus commodo lorem vel neque interdum pretium. Etiam ut mattis dolor, sed porttitor ante. Mauris euismod erat sed egestas blandit. Vivamus vel velit magna. Pellentesque vel justo eget sapien laoreet suscipit a et orci. Nam posuere ex orci, at dignissim purus sagittis convallis. Proin sed lacus sed est ullamcorper volutpat. Vivamus tempor sodales consectetur. Vestibulum nibh elit, ullamcorper sit amet eros nec, pharetra tincidunt sapien. Donec porta elit pretium ullamcorper sollicitudin. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Donec fermentum, mauris et consequat tristique, diam lectus ultricies augue, non rutrum mauris magna eu dolor. Sed id cursus nisl. Curabitur ornare faucibus neque id sagittis.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vitae.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vitae.', 'Lorem ipsum dolor sit amet.', 'Wild Code School', 'Apprentissage', ['Ludivine', 'Sagnole']],
        ['Chef de projet', 'Tours', '2020-05-21', '2021-01-16', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas malesuada augue eget urna ultricies, eu placerat nisi dapibus. Proin euismod tincidunt tempus. Vivamus commodo lorem vel neque interdum pretium. Etiam ut mattis dolor, sed porttitor ante. Mauris euismod erat sed egestas blandit. Vivamus vel velit magna. Pellentesque vel justo eget sapien laoreet suscipit a et orci. Nam posuere ex orci, at dignissim purus sagittis convallis. Proin sed lacus sed est ullamcorper volutpat. Vivamus tempor sodales consectetur. Vestibulum nibh elit, ullamcorper sit amet eros nec, pharetra tincidunt sapien. Donec porta elit pretium ullamcorper sollicitudin. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Donec fermentum, mauris et consequat tristique, diam lectus ultricies augue, non rutrum mauris magna eu dolor. Sed id cursus nisl. Curabitur ornare faucibus neque id sagittis.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vitae.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vitae.', 'Lorem ipsum dolor sit amet.', 'SEDIPEC', 'Mission', ['Antoine', 'Jezequel']],
        ['Lead Tech', 'Tours', '2021-02-04', null, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas malesuada augue eget urna ultricies, eu placerat nisi dapibus. Proin euismod tincidunt tempus. Vivamus commodo lorem vel neque interdum pretium. Etiam ut mattis dolor, sed porttitor ante. Mauris euismod erat sed egestas blandit. Vivamus vel velit magna. Pellentesque vel justo eget sapien laoreet suscipit a et orci. Nam posuere ex orci, at dignissim purus sagittis convallis. Proin sed lacus sed est ullamcorper volutpat. Vivamus tempor sodales consectetur. Vestibulum nibh elit, ullamcorper sit amet eros nec, pharetra tincidunt sapien. Donec porta elit pretium ullamcorper sollicitudin. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Donec fermentum, mauris et consequat tristique, diam lectus ultricies augue, non rutrum mauris magna eu dolor. Sed id cursus nisl. Curabitur ornare faucibus neque id sagittis.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vitae.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vitae.', 'Lorem ipsum dolor sit amet.', 'Metropole de Tours', 'Mission', ['Antoine', 'Jezequel']],
        ['Développeur', 'Bordeaux', '2020-05-03', '2020-07-18', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas malesuada augue eget urna ultricies, eu placerat nisi dapibus. Proin euismod tincidunt tempus. Vivamus commodo lorem vel neque interdum pretium. Etiam ut mattis dolor, sed porttitor ante. Mauris euismod erat sed egestas blandit. Vivamus vel velit magna. Pellentesque vel justo eget sapien laoreet suscipit a et orci. Nam posuere ex orci, at dignissim purus sagittis convallis. Proin sed lacus sed est ullamcorper volutpat. Vivamus tempor sodales consectetur. Vestibulum nibh elit, ullamcorper sit amet eros nec, pharetra tincidunt sapien. Donec porta elit pretium ullamcorper sollicitudin. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Donec fermentum, mauris et consequat tristique, diam lectus ultricies augue, non rutrum mauris magna eu dolor. Sed id cursus nisl. Curabitur ornare faucibus neque id sagittis.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vitae.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vitae.', 'Lorem ipsum dolor sit amet.', 'La Mobilerie', 'Mission', ['Leandro', 'Nicolas']],
        ['Développeur', 'Paris', '2020-07-18', null, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas malesuada augue eget urna ultricies, eu placerat nisi dapibus. Proin euismod tincidunt tempus. Vivamus commodo lorem vel neque interdum pretium. Etiam ut mattis dolor, sed porttitor ante. Mauris euismod erat sed egestas blandit. Vivamus vel velit magna. Pellentesque vel justo eget sapien laoreet suscipit a et orci. Nam posuere ex orci, at dignissim purus sagittis convallis. Proin sed lacus sed est ullamcorper volutpat. Vivamus tempor sodales consectetur. Vestibulum nibh elit, ullamcorper sit amet eros nec, pharetra tincidunt sapien. Donec porta elit pretium ullamcorper sollicitudin. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Donec fermentum, mauris et consequat tristique, diam lectus ultricies augue, non rutrum mauris magna eu dolor. Sed id cursus nisl. Curabitur ornare faucibus neque id sagittis.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vitae.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vitae.', 'Lorem ipsum dolor sit amet.', 'La Mobilerie', 'Mission', ['Leandro', 'Nicolas']],
        ['Stagiaire', 'Lyon', '2020-07-18', null, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas malesuada augue eget urna ultricies, eu placerat nisi dapibus. Proin euismod tincidunt tempus. Vivamus commodo lorem vel neque interdum pretium. Etiam ut mattis dolor, sed porttitor ante. Mauris euismod erat sed egestas blandit. Vivamus vel velit magna. Pellentesque vel justo eget sapien laoreet suscipit a et orci. Nam posuere ex orci, at dignissim purus sagittis convallis. Proin sed lacus sed est ullamcorper volutpat. Vivamus tempor sodales consectetur. Vestibulum nibh elit, ullamcorper sit amet eros nec, pharetra tincidunt sapien. Donec porta elit pretium ullamcorper sollicitudin. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Donec fermentum, mauris et consequat tristique, diam lectus ultricies augue, non rutrum mauris magna eu dolor. Sed id cursus nisl. Curabitur ornare faucibus neque id sagittis.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vitae.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vitae.', 'Lorem ipsum dolor sit amet.', 'CEFIM', 'Stage', ['Edouard', 'Lamy']],
        ['Chef de projet', 'Tours', '2021-07-24', null, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas malesuada augue eget urna ultricies, eu placerat nisi dapibus. Proin euismod tincidunt tempus. Vivamus commodo lorem vel neque interdum pretium. Etiam ut mattis dolor, sed porttitor ante. Mauris euismod erat sed egestas blandit. Vivamus vel velit magna. Pellentesque vel justo eget sapien laoreet suscipit a et orci. Nam posuere ex orci, at dignissim purus sagittis convallis. Proin sed lacus sed est ullamcorper volutpat. Vivamus tempor sodales consectetur. Vestibulum nibh elit, ullamcorper sit amet eros nec, pharetra tincidunt sapien. Donec porta elit pretium ullamcorper sollicitudin. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Donec fermentum, mauris et consequat tristique, diam lectus ultricies augue, non rutrum mauris magna eu dolor. Sed id cursus nisl. Curabitur ornare faucibus neque id sagittis.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vitae.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vitae.', 'Lorem ipsum dolor sit amet.', 'CEFIM', 'Mission', ['Nicolas', 'Mormiche']],
        ['Lead Tech', 'Strasbourg', '2020-01-30', '2020-07-24', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas malesuada augue eget urna ultricies, eu placerat nisi dapibus. Proin euismod tincidunt tempus. Vivamus commodo lorem vel neque interdum pretium. Etiam ut mattis dolor, sed porttitor ante. Mauris euismod erat sed egestas blandit. Vivamus vel velit magna. Pellentesque vel justo eget sapien laoreet suscipit a et orci. Nam posuere ex orci, at dignissim purus sagittis convallis. Proin sed lacus sed est ullamcorper volutpat. Vivamus tempor sodales consectetur. Vestibulum nibh elit, ullamcorper sit amet eros nec, pharetra tincidunt sapien. Donec porta elit pretium ullamcorper sollicitudin. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Donec fermentum, mauris et consequat tristique, diam lectus ultricies augue, non rutrum mauris magna eu dolor. Sed id cursus nisl. Curabitur ornare faucibus neque id sagittis.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vitae.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vitae.', 'Lorem ipsum dolor sit amet.', 'Institut Aurélie Favre', 'Mission', ['Nicolas', 'Marcaud']],
        ['Développeur', 'Strasbourg', '2020-07-31', '2020-12-10', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas malesuada augue eget urna ultricies, eu placerat nisi dapibus. Proin euismod tincidunt tempus. Vivamus commodo lorem vel neque interdum pretium. Etiam ut mattis dolor, sed porttitor ante. Mauris euismod erat sed egestas blandit. Vivamus vel velit magna. Pellentesque vel justo eget sapien laoreet suscipit a et orci. Nam posuere ex orci, at dignissim purus sagittis convallis. Proin sed lacus sed est ullamcorper volutpat. Vivamus tempor sodales consectetur. Vestibulum nibh elit, ullamcorper sit amet eros nec, pharetra tincidunt sapien. Donec porta elit pretium ullamcorper sollicitudin. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Donec fermentum, mauris et consequat tristique, diam lectus ultricies augue, non rutrum mauris magna eu dolor. Sed id cursus nisl. Curabitur ornare faucibus neque id sagittis.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vitae.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vitae.', 'Lorem ipsum dolor sit amet.', 'Open', 'Mission', ['Nicolas', 'Marcaud']],
        ['Développeur', 'Lille', '2020-12-10', null, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas malesuada augue eget urna ultricies, eu placerat nisi dapibus. Proin euismod tincidunt tempus. Vivamus commodo lorem vel neque interdum pretium. Etiam ut mattis dolor, sed porttitor ante. Mauris euismod erat sed egestas blandit. Vivamus vel velit magna. Pellentesque vel justo eget sapien laoreet suscipit a et orci. Nam posuere ex orci, at dignissim purus sagittis convallis. Proin sed lacus sed est ullamcorper volutpat. Vivamus tempor sodales consectetur. Vestibulum nibh elit, ullamcorper sit amet eros nec, pharetra tincidunt sapien. Donec porta elit pretium ullamcorper sollicitudin. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Donec fermentum, mauris et consequat tristique, diam lectus ultricies augue, non rutrum mauris magna eu dolor. Sed id cursus nisl. Curabitur ornare faucibus neque id sagittis.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vitae.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vitae.', 'Lorem ipsum dolor sit amet.', 'Institut Aurélie Favre', 'Mission', ['Nicolas', 'Marcaud']],
        ['Stagiaire', 'Brest', '2021-06-02', null, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas malesuada augue eget urna ultricies, eu placerat nisi dapibus. Proin euismod tincidunt tempus. Vivamus commodo lorem vel neque interdum pretium. Etiam ut mattis dolor, sed porttitor ante. Mauris euismod erat sed egestas blandit. Vivamus vel velit magna. Pellentesque vel justo eget sapien laoreet suscipit a et orci. Nam posuere ex orci, at dignissim purus sagittis convallis. Proin sed lacus sed est ullamcorper volutpat. Vivamus tempor sodales consectetur. Vestibulum nibh elit, ullamcorper sit amet eros nec, pharetra tincidunt sapien. Donec porta elit pretium ullamcorper sollicitudin. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Donec fermentum, mauris et consequat tristique, diam lectus ultricies augue, non rutrum mauris magna eu dolor. Sed id cursus nisl. Curabitur ornare faucibus neque id sagittis.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vitae.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vitae.', 'Lorem ipsum dolor sit amet.', 'Start&Growth', 'Stage', ['Florian', 'Fortier']],
        ['En formation', 'Tours', '2020-12-18', null, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas malesuada augue eget urna ultricies, eu placerat nisi dapibus. Proin euismod tincidunt tempus. Vivamus commodo lorem vel neque interdum pretium. Etiam ut mattis dolor, sed porttitor ante. Mauris euismod erat sed egestas blandit. Vivamus vel velit magna. Pellentesque vel justo eget sapien laoreet suscipit a et orci. Nam posuere ex orci, at dignissim purus sagittis convallis. Proin sed lacus sed est ullamcorper volutpat. Vivamus tempor sodales consectetur. Vestibulum nibh elit, ullamcorper sit amet eros nec, pharetra tincidunt sapien. Donec porta elit pretium ullamcorper sollicitudin. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Donec fermentum, mauris et consequat tristique, diam lectus ultricies augue, non rutrum mauris magna eu dolor. Sed id cursus nisl. Curabitur ornare faucibus neque id sagittis.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vitae.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vitae.', 'Lorem ipsum dolor sit amet.', 'Université de Tours', 'Formation', ['Patrick', 'Yim']],
        ['Technicien d\'assistance informatique', 'Angoulême', '2020-09-21', '2021-06-09', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas malesuada augue eget urna ultricies, eu placerat nisi dapibus. Proin euismod tincidunt tempus. Vivamus commodo lorem vel neque interdum pretium. Etiam ut mattis dolor, sed porttitor ante. Mauris euismod erat sed egestas blandit. Vivamus vel velit magna. Pellentesque vel justo eget sapien laoreet suscipit a et orci. Nam posuere ex orci, at dignissim purus sagittis convallis. Proin sed lacus sed est ullamcorper volutpat. Vivamus tempor sodales consectetur. Vestibulum nibh elit, ullamcorper sit amet eros nec, pharetra tincidunt sapien. Donec porta elit pretium ullamcorper sollicitudin. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Donec fermentum, mauris et consequat tristique, diam lectus ultricies augue, non rutrum mauris magna eu dolor. Sed id cursus nisl. Curabitur ornare faucibus neque id sagittis.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vitae.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vitae.', 'Lorem ipsum dolor sit amet.', 'Auchan', 'Mission', ['Kevin', 'Bertheau']],
        ['Technicien', 'Angoulême', '2021-10-15', null, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas malesuada augue eget urna ultricies, eu placerat nisi dapibus. Proin euismod tincidunt tempus. Vivamus commodo lorem vel neque interdum pretium. Etiam ut mattis dolor, sed porttitor ante. Mauris euismod erat sed egestas blandit. Vivamus vel velit magna. Pellentesque vel justo eget sapien laoreet suscipit a et orci. Nam posuere ex orci, at dignissim purus sagittis convallis. Proin sed lacus sed est ullamcorper volutpat. Vivamus tempor sodales consectetur. Vestibulum nibh elit, ullamcorper sit amet eros nec, pharetra tincidunt sapien. Donec porta elit pretium ullamcorper sollicitudin. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Donec fermentum, mauris et consequat tristique, diam lectus ultricies augue, non rutrum mauris magna eu dolor. Sed id cursus nisl. Curabitur ornare faucibus neque id sagittis.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vitae.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vitae.', 'Lorem ipsum dolor sit amet.', 'Auchan', 'Mission', ['Kevin', 'Bertheau']],
        ['Développeur', 'Moulins', '2020-08-13', '2020-12-24', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas malesuada augue eget urna ultricies, eu placerat nisi dapibus. Proin euismod tincidunt tempus. Vivamus commodo lorem vel neque interdum pretium. Etiam ut mattis dolor, sed porttitor ante. Mauris euismod erat sed egestas blandit. Vivamus vel velit magna. Pellentesque vel justo eget sapien laoreet suscipit a et orci. Nam posuere ex orci, at dignissim purus sagittis convallis. Proin sed lacus sed est ullamcorper volutpat. Vivamus tempor sodales consectetur. Vestibulum nibh elit, ullamcorper sit amet eros nec, pharetra tincidunt sapien. Donec porta elit pretium ullamcorper sollicitudin. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Donec fermentum, mauris et consequat tristique, diam lectus ultricies augue, non rutrum mauris magna eu dolor. Sed id cursus nisl. Curabitur ornare faucibus neque id sagittis.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vitae.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vitae.', 'Lorem ipsum dolor sit amet.', 'Umanis', 'Mission', ['Ludovic', 'Brault']],
        ['Chef de projet', 'Nice', '2021-01-05', '2021-04-11', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas malesuada augue eget urna ultricies, eu placerat nisi dapibus. Proin euismod tincidunt tempus. Vivamus commodo lorem vel neque interdum pretium. Etiam ut mattis dolor, sed porttitor ante. Mauris euismod erat sed egestas blandit. Vivamus vel velit magna. Pellentesque vel justo eget sapien laoreet suscipit a et orci. Nam posuere ex orci, at dignissim purus sagittis convallis. Proin sed lacus sed est ullamcorper volutpat. Vivamus tempor sodales consectetur. Vestibulum nibh elit, ullamcorper sit amet eros nec, pharetra tincidunt sapien. Donec porta elit pretium ullamcorper sollicitudin. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Donec fermentum, mauris et consequat tristique, diam lectus ultricies augue, non rutrum mauris magna eu dolor. Sed id cursus nisl. Curabitur ornare faucibus neque id sagittis.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vitae.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vitae.', 'Lorem ipsum dolor sit amet.', 'Umanis', 'Mission', ['Ludovic', 'Brault']],
        ['Lead Tech', 'Le Mans', '2021-04-11', null, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas malesuada augue eget urna ultricies, eu placerat nisi dapibus. Proin euismod tincidunt tempus. Vivamus commodo lorem vel neque interdum pretium. Etiam ut mattis dolor, sed porttitor ante. Mauris euismod erat sed egestas blandit. Vivamus vel velit magna. Pellentesque vel justo eget sapien laoreet suscipit a et orci. Nam posuere ex orci, at dignissim purus sagittis convallis. Proin sed lacus sed est ullamcorper volutpat. Vivamus tempor sodales consectetur. Vestibulum nibh elit, ullamcorper sit amet eros nec, pharetra tincidunt sapien. Donec porta elit pretium ullamcorper sollicitudin. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Donec fermentum, mauris et consequat tristique, diam lectus ultricies augue, non rutrum mauris magna eu dolor. Sed id cursus nisl. Curabitur ornare faucibus neque id sagittis.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vitae.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vitae.', 'Lorem ipsum dolor sit amet.', 'Umanis', 'Mission', ['Ludovic', 'Brault']],
        ['En formation', 'Béziers', '2021-10-03', null, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas malesuada augue eget urna ultricies, eu placerat nisi dapibus. Proin euismod tincidunt tempus. Vivamus commodo lorem vel neque interdum pretium. Etiam ut mattis dolor, sed porttitor ante. Mauris euismod erat sed egestas blandit. Vivamus vel velit magna. Pellentesque vel justo eget sapien laoreet suscipit a et orci. Nam posuere ex orci, at dignissim purus sagittis convallis. Proin sed lacus sed est ullamcorper volutpat. Vivamus tempor sodales consectetur. Vestibulum nibh elit, ullamcorper sit amet eros nec, pharetra tincidunt sapien. Donec porta elit pretium ullamcorper sollicitudin. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Donec fermentum, mauris et consequat tristique, diam lectus ultricies augue, non rutrum mauris magna eu dolor. Sed id cursus nisl. Curabitur ornare faucibus neque id sagittis.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vitae.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vitae.', 'Lorem ipsum dolor sit amet.', 'Wild Code School', 'Formation', ['Dimitri', 'Guillon']],
        ['Stagiaire', 'Langres', '2020-08-30', '2021-12-30', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas malesuada augue eget urna ultricies, eu placerat nisi dapibus. Proin euismod tincidunt tempus. Vivamus commodo lorem vel neque interdum pretium. Etiam ut mattis dolor, sed porttitor ante. Mauris euismod erat sed egestas blandit. Vivamus vel velit magna. Pellentesque vel justo eget sapien laoreet suscipit a et orci. Nam posuere ex orci, at dignissim purus sagittis convallis. Proin sed lacus sed est ullamcorper volutpat. Vivamus tempor sodales consectetur. Vestibulum nibh elit, ullamcorper sit amet eros nec, pharetra tincidunt sapien. Donec porta elit pretium ullamcorper sollicitudin. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Donec fermentum, mauris et consequat tristique, diam lectus ultricies augue, non rutrum mauris magna eu dolor. Sed id cursus nisl. Curabitur ornare faucibus neque id sagittis.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vitae.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vitae.', 'Lorem ipsum dolor sit amet.', 'Radio Béton', 'Stage', ['Adrien', 'Cauvin']],
        ['Développeur', 'Marseilles', '2021-12-30', null, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas malesuada augue eget urna ultricies, eu placerat nisi dapibus. Proin euismod tincidunt tempus. Vivamus commodo lorem vel neque interdum pretium. Etiam ut mattis dolor, sed porttitor ante. Mauris euismod erat sed egestas blandit. Vivamus vel velit magna. Pellentesque vel justo eget sapien laoreet suscipit a et orci. Nam posuere ex orci, at dignissim purus sagittis convallis. Proin sed lacus sed est ullamcorper volutpat. Vivamus tempor sodales consectetur. Vestibulum nibh elit, ullamcorper sit amet eros nec, pharetra tincidunt sapien. Donec porta elit pretium ullamcorper sollicitudin. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Donec fermentum, mauris et consequat tristique, diam lectus ultricies augue, non rutrum mauris magna eu dolor. Sed id cursus nisl. Curabitur ornare faucibus neque id sagittis.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vitae.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vitae.', 'Lorem ipsum dolor sit amet.', 'Baddack', 'Mission', ['Adrien', 'Cauvin']],
        ['Développeur', 'Poitiers', '2020-11-11', '2021-05-07', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas malesuada augue eget urna ultricies, eu placerat nisi dapibus. Proin euismod tincidunt tempus. Vivamus commodo lorem vel neque interdum pretium. Etiam ut mattis dolor, sed porttitor ante. Mauris euismod erat sed egestas blandit. Vivamus vel velit magna. Pellentesque vel justo eget sapien laoreet suscipit a et orci. Nam posuere ex orci, at dignissim purus sagittis convallis. Proin sed lacus sed est ullamcorper volutpat. Vivamus tempor sodales consectetur. Vestibulum nibh elit, ullamcorper sit amet eros nec, pharetra tincidunt sapien. Donec porta elit pretium ullamcorper sollicitudin. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Donec fermentum, mauris et consequat tristique, diam lectus ultricies augue, non rutrum mauris magna eu dolor. Sed id cursus nisl. Curabitur ornare faucibus neque id sagittis.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vitae.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vitae.', 'Lorem ipsum dolor sit amet.', 'MCD Mutuelle', 'Mission', ['Alan', 'Daunay']],
        ['Développeur', 'Poitiers', '2021-08-19', null, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas malesuada augue eget urna ultricies, eu placerat nisi dapibus. Proin euismod tincidunt tempus. Vivamus commodo lorem vel neque interdum pretium. Etiam ut mattis dolor, sed porttitor ante. Mauris euismod erat sed egestas blandit. Vivamus vel velit magna. Pellentesque vel justo eget sapien laoreet suscipit a et orci. Nam posuere ex orci, at dignissim purus sagittis convallis. Proin sed lacus sed est ullamcorper volutpat. Vivamus tempor sodales consectetur. Vestibulum nibh elit, ullamcorper sit amet eros nec, pharetra tincidunt sapien. Donec porta elit pretium ullamcorper sollicitudin. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Donec fermentum, mauris et consequat tristique, diam lectus ultricies augue, non rutrum mauris magna eu dolor. Sed id cursus nisl. Curabitur ornare faucibus neque id sagittis.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vitae.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vitae.', 'Lorem ipsum dolor sit amet.', 'MCD Mutuelle', 'Mission', ['Alan', 'Daunay']],
        ['Apprenti', 'Bourges', '2021-02-01', null, 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas malesuada augue eget urna ultricies, eu placerat nisi dapibus. Proin euismod tincidunt tempus. Vivamus commodo lorem vel neque interdum pretium. Etiam ut mattis dolor, sed porttitor ante. Mauris euismod erat sed egestas blandit. Vivamus vel velit magna. Pellentesque vel justo eget sapien laoreet suscipit a et orci. Nam posuere ex orci, at dignissim purus sagittis convallis. Proin sed lacus sed est ullamcorper volutpat. Vivamus tempor sodales consectetur. Vestibulum nibh elit, ullamcorper sit amet eros nec, pharetra tincidunt sapien. Donec porta elit pretium ullamcorper sollicitudin. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Donec fermentum, mauris et consequat tristique, diam lectus ultricies augue, non rutrum mauris magna eu dolor. Sed id cursus nisl. Curabitur ornare faucibus neque id sagittis.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vitae.', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Morbi vitae.', 'Lorem ipsum dolor sit amet.', 'CNAV', 'Apprentissage', ['Baptiste', 'Ternoir']],
    ];

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    
    public function load(ObjectManager $manager)
    {
        foreach(self::FAKE_SKILLS_CATEGORIES as $fakeSkillsCategory)
        {
            $category = new Category;

            $category->setName($fakeSkillsCategory[0]);

            $manager->persist($category);
            $manager->flush();
        }

        foreach(self::FAKE_SKILLS as $fakeSkill)
        {
            $skill = new Skill;
            $category = $manager->getRepository(Category::class)->findOneBy(['name' => $fakeSkill[1]]);

            $skill->setName($fakeSkill[0]);

            if($category)
            {
                $skill->setCategory($category);
            }

            $manager->persist($skill);
            $manager->flush();
        }

        foreach(self::FAKE_SKILLS_LEVELS as $fakeSkillLevel)
        {
            $skillLevel = new SkillLevel;

            $skillLevel->setStatus($fakeSkillLevel[0]);

            $manager->persist($skillLevel);
            $manager->flush();
        }

        foreach(self::FAKE_STATII as $fakeStatus)
        {
            $status = new Status;

            $status->setName($fakeStatus[0]);

            $manager->persist($status);
            $manager->flush();
        }

        foreach(self::FAKE_PROFESSIONS as $fakeProfession)
        {
            $profession = new Profession;

            $profession->setName($fakeProfession[0]);

            $manager->persist($profession);
            $manager->flush();
        }

        foreach(self::FAKE_DOCUMENT_TYPES as $fakeDocumentType)
        {
            $documentType = new TypeDocument;

            $documentType->setName($fakeDocumentType[0]);

            $manager->persist($documentType);
            $manager->flush();
        }

        foreach(self::FAKE_EXPERIENCE_TYPES as $fakeExperienceType)
        {
            $experienceType = new TypeExperience;

            $experienceType->setName($fakeExperienceType[0]);

            $manager->persist($experienceType);
            $manager->flush();
        }

        foreach(self::FAKE_COMPANIES as $fakeCompany)
        {
            $company = new Company;

            $company->setName($fakeCompany[0])
                    ->setEmail($fakeCompany[1])
                    ->setPhone($fakeCompany[2]);

            $manager->persist($company);
            $manager->flush();
        }

        foreach(self::FAKE_PROFILES as $fakeProfile)
        {
            $profile = new Profile;
            $profession = $manager->getRepository(Profession::class)->findOneBy(['name' => $fakeProfile[7]]);
            $status = $manager->getRepository(Status::class)->findOneBy(['name' => $fakeProfile[8]]);

            $profile->setFirstname($fakeProfile[0])
                    ->setLastname($fakeProfile[1])
                    ->setAdress($fakeProfile[2])
                    ->setPostal($fakeProfile[3])
                    ->setTown($fakeProfile[4])
                    ->setPhone($fakeProfile[5])
                    ->setDate(new \DateTimeImmutable($fakeProfile[10]))
                    ->setProfession($profession)
                    ->setStatus($status);

            if($fakeProfile[6])
            {
                $profile->setEmail($fakeProfile[6]);
            }

            if($fakeProfile[9])
            {
                $profile->setDisponibility($fakeProfile[9]);
            }

            if($fakeProfile[11])
            {
                $profile->setDateModification(new \DateTimeImmutable($fakeProfile[11]));
            }

            $manager->persist($profile);
            $manager->flush();
        }

        foreach(self::FAKE_USERS as $fakeUser)
        {
            $user = new User;
            $profile = null;

            if($fakeUser[5])
            {
                $profile = $manager->getRepository(Profile::class)->findOneBy([
                    'firstname' => $fakeUser[5][0],
                    'lastname' => $fakeUser[5][1]
                ]);
            }

            $passwordEncoded = $this->encoder->encodePassword($user, $fakeUser[2]);
            
            $user->setusername($fakeUser[0])
                 ->setRoles($fakeUser[1])
                 ->setPassword($passwordEncoded)
                 ->setDate(new \DateTimeImmutable($fakeUser[3]))
                 ->setEmail($fakeUser[4])
                 ->setProfile($profile);

            $manager->persist($user);
            $manager->flush();
        }

        foreach(self::FAKE_PROFILES_HAS_SKILLS as $fakeProfileHasSkills)
        {
            $profileHasSkills = new ProfileSkill;
            $skill = $manager->getRepository(Skill::class)->findOneBy([ 'name' => $fakeProfileHasSkills[1]]);
            $profile = $manager->getRepository(Profile::class)->findOneBy([
                'firstname' => $fakeProfileHasSkills[2][0],
                'lastname' => $fakeProfileHasSkills[2][1]
            ]);
            $level = $manager->getRepository(SkillLevel::class)->findOneBy([ 'status' => $fakeProfileHasSkills[3]]);

            $profileHasSkills->setAppreciation($fakeProfileHasSkills[0])
                             ->setSkill($skill)
                             ->setProfile($profile)
                             ->setLevel($level);

            $manager->persist($profileHasSkills);
            $manager->flush();
        }

        foreach(self::FAKE_EXPERIENCES as $fakeExperience)
        {
            $experience = new Experience;
            $company = $manager->getRepository(Company::class)->findOneBy([ 'name' => $fakeExperience[8] ]);
            $type = $manager->getRepository(TypeExperience::class)->findOneBy([ 'name' => $fakeExperience[9]]);
            $profile = $manager->getRepository(Profile::class)->findOneBy([
                'firstname' => $fakeExperience[10][0],
                'lastname' => $fakeExperience[10][1]
            ]);

            $experience->setFunction($fakeExperience[0])
                        ->setLocation($fakeExperience[1])
                        ->setDateStart(new \DateTimeImmutable($fakeExperience[2]))
                        ->setDescription($fakeExperience[4])
                        ->setContext($fakeExperience[5])
                        ->setAchievement($fakeExperience[6])
                        ->setTechEnv($fakeExperience[7])
                        ->setCompany($company)
                        ->setType($type)
                        ->setProfile($profile);

            if($fakeExperience[3])
            {
                $experience->setDateEnd(new \DateTimeImmutable($fakeExperience[3]));
            }
                        

            $manager->persist($experience);
            $manager->flush();
        }
    }
}
