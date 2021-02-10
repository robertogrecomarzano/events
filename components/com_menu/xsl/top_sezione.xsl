<?xml version="1.0" encoding="UTF-8"?>
<xsl:stylesheet version="1.0"
	xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
	<xsl:output method="html" />
	<xsl:template match="/">
		<xsl:for-each select='//node[@id=$folder]/node'> <!-- Prendo solo i nodi figli di $folder -->
			<xsl:if test="not(@hide)">

				<xsl:if test="@icon!=''">
					<xsl:variable name="link">
						<xsl:value-of select="@icon" />
					</xsl:variable>
				</xsl:if>


				<xsl:variable name="link-style">
					<xsl:choose>
						<xsl:when test="@icon-style!=''">
							<xsl:value-of select="@icon-style" />
						</xsl:when>
						<xsl:otherwise>
							fas
						</xsl:otherwise>
					</xsl:choose>
				</xsl:variable>


				<xsl:variable name="link">
					<xsl:choose>
						<xsl:when test="@icon!=''">
							<xsl:value-of select="@icon" />
						</xsl:when>
					</xsl:choose>
				</xsl:variable>

				<div class="col-xs-12 col-sm-6 col-md-4 col-lg-3">


					<xsl:variable name="panel-class">
						<xsl:choose>
							<xsl:when test="@panel-color!=''">
								<xsl:value-of select="@panel-color" />
							</xsl:when>
							<xsl:otherwise>
								panel-primary
							</xsl:otherwise>
						</xsl:choose>
					</xsl:variable>
					<div class="panel {$panel-class}">

						<div class="panel-heading">
							<div class="row">
								<div class="col-xs-3">
									<a>
										<xsl:attribute name='href'>
								<xsl:value-of select="@url" />
							</xsl:attribute>
										<i class="{$link-style} fa-{$link} fa-5x"></i>
									</a>
								</div>
								<div class="col-xs-9 text-right">
									<div>
										<a>
											<xsl:attribute name='href'>
								<xsl:value-of select="@url" />
							</xsl:attribute>
											<xsl:value-of select="label" />
										</a>
									</div>
								</div>
							</div>
						</div>
						<a>
							<xsl:attribute name='href'>
								<xsl:value-of select="@url" />
							</xsl:attribute>
							<div class="panel-body" style="height:100px;"
								data-simplebar="" data-simplebar-auto-hide="false">
								<div>
									<xsl:value-of select="pagelabel" />
								</div>

							</div>
						</a>
					</div>
				</div>


			</xsl:if>
		</xsl:for-each>
	</xsl:template>
</xsl:stylesheet>