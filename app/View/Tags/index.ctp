<!-- File: /app/View/Tags/index.ctp -->

<?php
echo $this->Form->create(
	false, 
	array(
		'action' => 'index'
	)
); ?>
<table>
	<tr>
		<td>
			<?php echo $this->Form->input(
				'start', 
				array(
					'type' => 'datetime',
					'timeFormat' => null,
					'minYear' => 1970
				)
			); ?>
			<br>
			<?php echo $this->Form->input(
				'end', 
				array(
					'type' => 'datetime',
					'timeFormat' => null,
					'minYear' => 1970
				)
			); ?>
		</td>
		<td>
			<?php echo $this->Form->input(
				'tagSearch',
				array(
					'type' => 'text'
				)
			); ?>
		</td>
		<td>
			<?php echo $this->Form->input(
				'scopeFilter',
				array(
					'type' => 'select',
					'options' => array(
						'Universal' => 'Universal', 
						'Not Universal' => 'Not Universal'
					),
					'empty' => 'All'
				)
			); ?>
			<br>
			<?php echo $this->Form->input(
				'originFilter',
				array(
					'type' => 'select',
					'options' => array(
						'ArchVision Only' => 'ArchVision Only', 
						'Custom Only' => 'Custom Only'
					),
					'empty' => 'All'
				)
			); ?>
		</td>
		<td>
			<?php echo $this->Form->end('Go'); ?>
		</td>
	</tr>
<br><br>

<!-- <?php echo debug($tags); ?> -->

<table>
	

<?php if (isset($noResults)): ?>

	<tr>
		<?php foreach ($tags[0] as $table): ?>
			<?php foreach (array_keys($table) as $key): ?>
				<th><?php echo $key; ?></th>
			<?php endforeach; ?>
		<?php endforeach; ?>
	</tr>

	<?php foreach ($tags as $tag): ?>
		<tr>
		<?php foreach ($tag as $table): ?>
			<?php foreach ($table as $field): ?>
				<td><?php echo trim($field); ?></td>
			<?php endforeach; ?>
		<?php endforeach; ?>
		</tr>
	<?php endforeach; ?>

<?php else: ?>

	<tr>
		<?php foreach ($tags[0] as $table): ?>
			<?php foreach (array_keys($table) as $key): ?>
				<th><?php echo $key; ?></th>
			<?php endforeach; ?>
		<?php endforeach; ?>
		<th>Remove From Universal</th>
	</tr>

	<?php foreach ($tags as $i => $tag): ?>
		<tr>
		<?php foreach ($tag as $table): ?>
			<?php if (isset($table['tag_id'])) {
				$tagId = $table['tag_id'];
				echo $this->Form->create(
					'Label',
					array(
						'url' => array('controller' => 'labels', 'action' => 'edit/' . $tagId),
						'class' => 'updateForm'
					)
				);
				echo $this->Form->hidden(
					'id',
					array(
						'default' => $tagId
					)
				);
			} ?>
			<?php foreach ($table as $key => $field): ?>
				<?php if ($key == 'void'): ?>
					<td <?php echo "id='" . $tagId . "'"?>><?php echo trim($field); ?></td>
				<?php else: ?>
					<td><?php echo trim($field); ?></td>
				<?php endif; ?>
			<?php endforeach; ?>
		<?php endforeach; ?>
			<td>
				<?php 
				echo $this->Form->checkbox(
					'void',
					array(
						'class' => 'voidCheckbox'
					)
				); 
				echo $this->Form->end();
				?>
			</td>
		</tr>
	<?php endforeach; ?>

<?php endif; ?>

</table>

<?php echo $this->Html->script('edit'); ?>