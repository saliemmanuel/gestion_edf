<nav class="navbar navbar-inverse navbar-fixed-top">

	<div class="container-fluid">

		<div class="navbar-header">
			<?php if ($_SESSION['user']['role'] == 'ADMIN') { ?>
				<a href="adminPage.php" class="navbar-brand">Gestion Departement Maths/Infos </a>
			<?php } ?>

			<?php if ($_SESSION['user']['role'] == 'CD') { ?>
				<a href="chefDeparPage.php" class="navbar-brand">Gestion Departement Maths/Infos </a>
			<?php } ?>

			<?php if ($_SESSION['user']['role'] == 'ENSEIGNANT') { ?>
				<a href="#" class="navbar-brand">Gestion Departement Maths/Infos </a>
			<?php } ?>
		</div>

		<ul class="nav navbar-nav">

			<?php if ($_SESSION['user']['role'] == 'CD') { ?>
				<li><a href="pageSalle.php">
						<i class="fa fa-magic"></i>
						&nbsp Gerer les Salles
					</a>
				</li>
				<li><a href="pageUE.php">
						<i class="fa fa-folder-open"></i>
						&nbsp Gerer les UE
					</a>
				</li>
				<li><a href="pageEtudiant.php">
						<i class="fa fa-users"></i>
						&nbsp Gerer les Etudiants
					</a>
				</li>

				<li><a href="#">
						<i class="fa fa-file-text-o"></i>
						&nbsp Gerer les Resultats
					</a>
				</li>
			<?php } ?>

			<?php if ($_SESSION['user']['role'] == 'ADMIN') { ?>

				<li><a href="adminPage.php">
						<i class="fa fa-users"></i>
						&nbsp Gerer les Utilisteurs
					</a>
				</li>

			<?php } ?>

		</ul>


		<ul class="nav navbar-nav navbar-right">

			<li>
				<a href="editerUtilisateur.php?id=<?php echo $_SESSION['user']['iduser'] ?>">
					<i class="fa fa-user-circle-o"></i>
					<?php echo  ' ' . $_SESSION['user']['login'] ?>
				</a>
			</li>

			<li>
				<a href="seDeconnecter.php">
					<i class="fa fa-sign-out"></i>
					&nbsp Se déconnecter
				</a>
			</li>

		</ul>

	</div>
</nav>