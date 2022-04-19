<style type="text/css">

	

	#contents{
		width: 98%;
		height: auto;
		margin: 10px;
		float: left;
		background-color: none;
	}

	#table{
	 	width: 100%;
		height: 180px;	
		border: 1px solid gray;
		border-radius: 10px;
		margin-bottom: 20px;
		background-color: rgba(255,255,255,0.6);
	}	
	#table_pic{
		width: 130px;		
	}
	#img_cut{
		width: 100px;
		height: auto;
		max-height: 120px;
		overflow: hidden;
		border-radius: 10px;
		box-shadow: 3px 3px 10px lightgray;
		margin: auto;

	}
	#pic1{
		width: 100px;
		height: auto;
		background-size: contain;
		background-repeat: no-repeat;
	}
	#left{
		width: 70%;
		height: auto;		
		float: left;
	}

	#right{
		height: 100%;
		width: 28%;
		border-left: 1px solid gray;
		float: right;
		display: inline-block;
		overflow: hidden;
		background-color: white;
		padding: 5px;
		padding-left: 15px;
		padding-top: 150px;
	}
	#right h4{
		border: 1px solid gray;
		width: 80%;
		margin-bottom: 10px;
		border-radius: 10px;
		padding: 10px;

	}

	#top_td{
		height: 40px;
		padding-left: 10px;
		background-color: lightgray;
	}

	#title{
		width: 90%;
		height:80px;		
		background-color: lightgray;
		padding: 10px;		

		border-left: 10px solid gray;
		margin-bottom: 50px;
		padding-top: 20px;
	}

	section{
		border: 1px solid lightgray;
		padding: 5px;
		width: 80%;
		height: auto;
		margin:auto;
		margin-left: 10%;
		margin-top: 30px;
		display: inline-block;
	}

	@media(min-width: 1021px) and (max-width: 1300px){
    	section{
    		width: 90%;
    		margin-left: 5%;
    	}    	
    }
    @media (min-width: 951px)and(max-width: 1020px){
    	section{
    		width: 100%;
    		margin-left: 0;
    	}    	
    }
    @media (max-width: 950px){
    	section{
    		width: 100%;
    		margin-left: 0;
    	}     
    	
    	#right{
    		display: none;
    	}
    	#left{
    		width: 100%;
    		padding-right: 10px;
    	}	

    }




</style>

<section>
	<div id = "title">
		<h2>게시물 보기</h2>
	</div>


		


			<div id  ="left">        
				<table id = "table">
					<tr>
						<td id = "top_td" colspan="2"><h5><b><?= $title?></b></h5></td>
					</tr>
					<tr>
						<td id = "table_pic" rowspan="4">
							<div id = "img_cut">
								<img src="/img/users/<?=$user?>/profile/<?= $img?>" onerror="this.src='/img/error/no_img.png'" id = "pic1">		

								</div>
							</div>
						</td>
						<td>작성자 : <?= $user?></td>
					</tr>
					<tr>			
						<td>작성일 : <?= $created?></td>
					</tr>
					<tr>			
						<td>수정일 : <?= $updated?></td>
					</tr>
				

					<tr>			
						<td colspan="2">수정</td>
					</tr>
				</table>	
				<style type="text/css">
					#area{
						width: 100%;
						min-height: 600px;
						height: auto;	
						background-color: ivory;	
						padding: 10px;
						border: 1px solid gray;	
						overflow: auto;
					}
					.news{
						height: auto;						
						margin: 5px;
						padding: 5px;
						border-bottom : 1px solid lightgray;
						width: 90%; 
					}


				</style>
				<div id = "area">
				 <?= $contents ?>
				</div>	

				
			</div>

			<div id = "right">
				<h4>최근 게시물</h4>
				<hr>
				<?php
				$arr = $this->result->get_list('board','공지사항',0,5);
				$arr = $arr['rs'];
				
				foreach($arr as $row)
				{
					print "<a href = ''><div class = 'news'>
						<h5><b>{$row['title']}</b></h5>
						ㄴ작성자 : {$row['user']}
					</div></a>";
				}
				 ?>			

			</div>

		

	

	<style type="text/css">
			#reply{
				height: auto;
				width: 100%;
				background-clip: white;
				padding: 10px;
				clear: both;

			}
			.replys{
				height: auto;
				border-bottom: 1px solid black;
			}
		</style>

	
		<div id = "reply">
			<?php 
				//from, board, start, end, like, select, join, where

				$join[0] = ['user u', 'u.id = r.user', 'left'];
				$join[1] = ['like_r lr', 'r.num = lr.reply_num', 'left'];
				$select = 'u.*, r.*, ifnull(sum(lr.good), 0) good, ifnull(sum(lr.poor), 0) poor';
				$having = ['r.board_num' => 60];
				$group = 'lr.user';				
				$rs = $this->result->get_list('reply r', '', '', '', '',  $join, $select, $having, $group);

				var_dump($rs);
	
			?>


	
		</div>



		<script type="text/javascript">
			
		</script>


	

		 
	</div>
</section>